<?php

namespace App\Services\Registry;

use Illuminate\Support\Facades\Log;
use JsonStreamingParser\Listener\ListenerInterface;

class StreamingZapListener implements ListenerInterface
{
    private array $stack = [];
    private string $currentKey = '';
    private array $buffer = [];

    private bool $inObject = false;
    private string $objectKey = '';
    private array $currentObject = [];

    private bool $inArray = false;
    private string $arrayKey = '';
    private array $currentArray = [];

    private $callback;
    private array $arrayFields = ['napr', 'inj', 'usl'];

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function startDocument(): void
    {
        $this->resetState();
        Log::debug('Начало обработки документа');
    }

    public function endDocument(): void
    {
        Log::debug('Обработка документа завершена');
    }

    private function resetState(): void
    {
        $this->stack = [];
        $this->currentKey = '';
        $this->buffer = [];
        $this->inObject = false;
        $this->objectKey = '';
        $this->currentObject = [];
        $this->inArray = false;
        $this->arrayKey = '';
        $this->currentArray = [];
    }

    public function startObject(): void
    {
        if ($this->inObject) {
            // Если уже внутри объекта, сохраняем текущий
            $this->stack[] = [
                'type' => 'object',
                'key' => $this->objectKey,
                'value' => $this->currentObject
            ];
        }

        $this->inObject = true;
        $this->objectKey = $this->currentKey;
        $this->currentObject = [];

        Log::debug("Start object: " . $this->currentKey);
    }

    public function endObject(): void
    {
        Log::debug("End object: " . $this->objectKey);

        if ($this->inArray) {
            // Если внутри массива, добавляем объект в массив
            $this->currentArray[] = $this->currentObject;
        } else {
            // Иначе добавляем в стек или буфер
            if (!empty($this->stack)) {
                $parent = array_pop($this->stack);
                $parent['value'][$this->objectKey] = $this->currentObject;
                $this->stack[] = $parent;
            } else {
                $this->buffer[$this->objectKey] = $this->currentObject;
            }
        }

        // Восстанавливаем предыдущий объект из стека
        if (!empty($this->stack) && end($this->stack)['type'] === 'object') {
            $parent = array_pop($this->stack);
            $this->currentObject = $parent['value'];
            $this->objectKey = $parent['key'];
        } else {
            $this->inObject = false;
            $this->objectKey = '';
        }

        // Обработка объекта zap
        if ($this->objectKey === 'zap' && isset($this->currentObject['n_zap'])) {
            $this->processZapItem($this->currentObject);
        }
    }

    public function startArray(): void
    {
        $this->inArray = true;
        $this->arrayKey = $this->currentKey;
        $this->currentArray = [];
        Log::debug("Start array: " . $this->currentKey);
    }

    public function endArray(): void
    {
        Log::debug("End array: " . $this->arrayKey);

        if (in_array($this->arrayKey, $this->arrayFields)) {
            $this->normalizeSpecialArray($this->currentArray);
        }

        if ($this->inObject) {
            $this->currentObject[$this->arrayKey] = $this->currentArray;
        } else {
            if (!empty($this->stack)) {
                $parent = array_pop($this->stack);
                $parent['value'][$this->arrayKey] = $this->currentArray;
                $this->stack[] = $parent;
            } else {
                $this->buffer[$this->arrayKey] = $this->currentArray;
            }
        }

        $this->inArray = false;
        $this->arrayKey = '';
    }

    private function normalizeSpecialArray(array &$array): void
    {
        if (empty($array)) return;

        // Если первый элемент уже содержит данные (не ассоциативный массив)
        if (!is_array($array[0]) || !isset($array[0][$this->arrayKey])) {
            return;
        }

        $normalized = [];
        foreach ($array as $item) {
            if (isset($item[$this->arrayKey])) {
                $normalized[] = $item[$this->arrayKey];
            }
        }

        if (!empty($normalized)) {
            $array = $normalized;
        }
    }

    public function key(string $key): void
    {
        $this->currentKey = $key;
    }

    public function value($value): void
    {
        if ($this->inObject) {
            $this->currentObject[$this->currentKey] = $value;
        } elseif ($this->inArray) {
            $this->currentArray[] = $value;
        }
    }

    private function processZapItem(array $zapItem): void
    {
        try {
            // Нормализация специальных полей
            foreach ($this->arrayFields as $field) {
                if (isset($zapItem[$field]) && !is_array($zapItem[$field])) {
                    $zapItem[$field] = [$zapItem[$field]];
                }
            }

            // Получаем данные регистра
            $registryData = $this->findRegistryData();

            call_user_func($this->callback, $zapItem, $registryData);
            Log::debug('Zap item processed', ['n_zap' => $zapItem['n_zap'] ?? null]);
        } catch (\Exception $e) {
            Log::error('Error processing zap item', [
                'error' => $e->getMessage(),
                'zapItem' => $zapItem
            ]);
        }
    }

    private function findRegistryData(): array
    {
        // Ищем данные регистра в буфере или стеке
        if (isset($this->buffer['registry'])) {
            return $this->buffer['registry'];
        }

        foreach ($this->stack as $item) {
            if (isset($item['value']['registry'])) {
                return $item['value']['registry'];
            }
        }

        return [];
    }

    public function whitespace(string $whitespace): void
    {
        // Игнорируем пробельные символы
    }
}
