<script setup lang="ts">

</script>

<template>
  <NForm :model="currentZsl" class="grid grid-cols-2 gap-4 h-full">
    <NFormItem label="Номер записи в реестре случаев" name="idcase" path="idcase">
      <NInput v-model:value="currentZsl.idcase" />
    </NFormItem>
    <NFormItem label="Условия оказания медицинской помощи" name="usl_ok" path="usl_ok">
      <NInput v-model:value="currentZsl.usl_ok" />
    </NFormItem>
    <NFormItem label="Вид медицинской помощи" name="vidpom" path="vidpom">
      <NInput v-model:value="currentZsl.vidpom" />
    </NFormItem>
    <NFormItem label="Форма оказания медицинской помощи" name="for_pom" path="for_pom">
      <NInput v-model:value="currentZsl.for_pom" />
    </NFormItem>
    <NFormItem label="Код МО, направившего на лечение" name="npr_mo" path="npr_mo">
      <NInput v-model:value="currentZsl.npr_mo" />
    </NFormItem>
    <NFormItem label="Дата направления на лечение" name="npr_date" path="npr_date">
      <NInput v-model:value="currentZsl.npr_date" />
    </NFormItem>
    <NFormItem label="Код МО" name="lpu" path="lpu">
      <NInput v-model:value="currentZsl.lpu" />
    </NFormItem>
    <NFormItem label="" name="vbr" path="vbr">
      <NInput v-model:value="currentZsl.vbr" />
    </NFormItem>
    <NFormItem label="Дата начала лечения" name="date_z_1" path="date_z_1">
      <NInput v-model:value="currentZsl.date_z_1" />
    </NFormItem>
    <NFormItem label="Дата окончания лечения" name="date_z_2" path="date_z_2">
      <NInput v-model:value="currentZsl.date_z_2" />
    </NFormItem>
    <NFormItem label="" name="p_otk" path="p_otk">
      <NInput v-model:value="currentZsl.p_otk" />
    </NFormItem>
    <NFormItem label="" name="rslt_d" path="rslt_d">
      <NInput v-model:value="currentZsl.rslt_d" />
    </NFormItem>
    <NFormItem label="Продолжительность госпитализации" name="kd_z" path="kd_z">
      <NInput v-model:value="currentZsl.kd_z" />
    </NFormItem>
    <NFormItem label="Вес при рождении" name="vnov_m" path="vnov_m">
      <NInput v-model:value="currentZsl.vnov_m" />
    </NFormItem>
    <NFormItem label="Результат обращения/госпитализации" name="rslt" path="rslt">
      <NInput v-model:value="currentZsl.rslt" />
    </NFormItem>
    <NFormItem label="Исход заболевания" name="ishod" path="ishod">
      <NInput v-model:value="currentZsl.ishod" />
    </NFormItem>
    <NFormItem label="Особый случай" name="os_sluch" path="os_sluch">
      <NInput v-model:value="currentZsl.os_sluch" />
    </NFormItem>
    <NFormItem label="Признак внутрибольничного перевода" name="vb_p" path="vb_p">
      <NInput v-model:value="currentZsl.vb_p" />
    </NFormItem>
    <NFormItem label="Код способа оплаты медицинской помощи" name="idsp" path="idsp">
      <NInput v-model:value="currentZsl.idsp" />
    </NFormItem>
    <NFormItem label="Сумма, выставленная к оплате" name="sumv" path="sumv">
      <NInput v-model:value="currentZsl.sumv" />
    </NFormItem>
  </NForm>
</template>

<style scoped>

</style>