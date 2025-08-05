<script setup>
import AuthLayout from "../../layouts/AuthLayout.vue";
import Card from "../../components/app/card/Card.vue";
import {useForm} from "@inertiajs/vue3";
import {useMessage} from "../../../composables/useMessage.js";

defineOptions({ layout: AuthLayout })

const form = useForm({
    'login': null,
    'password': null
})

const submit = () => {
    form.post(route('web.login'), {
        onError: (err) => {
            useMessage().error(err.message)
        }
    })
}
</script>

<template>
    <Card title="Авторизация">
        <NForm id="authForm" @submit.prevent="submit">
            <NFormItem label="Логин">
                <NInput v-model:value="form.login" />
            </NFormItem>
            <NFormItem label="Пароль">
                <NInput v-model:value="form.password" type="password" />
            </NFormItem>
        </NForm>
        <template #footer>
            <NSpace vertical>
                <NButton attr-type="submit" form="authForm" type="primary" size="large" secondary block style="border-radius: 8px;">
                    Войти
                </NButton>
            </NSpace>
        </template>
    </Card>
</template>

<style scoped>

</style>
