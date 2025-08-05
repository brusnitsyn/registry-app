<script setup>
import CountUslsWidget from "../components/app/widget/CountUslsWidget.vue"
import MisCountUslsStationar from "../components/app/widget/MisCountUslsStationarWidget.vue"
import MisCountUslsPolyclinicWidget from "../components/app/widget/MisCountUslsPolyclinicWidget.vue"
import { Head } from '@inertiajs/vue3'
import AppLayout from "../layouts/AppLayout.vue";
import CountUslSingle from "../components/app/widget/CountUslSingle.vue";
</script>

<template>
    <Head title="Статистика" />
    <AppLayout title="Статистика">
        <NFlex vertical>
            <NEl style="background-color: var(--tab-color); padding: 10px 24px 24px 24px; border-radius: 8px;">
                <NSpace vertical>
                    <NH3 style="margin-bottom: 6px; margin-top: 6px;">
                        Реестры
                    </NH3>
                    <NGrid :cols="5" x-gap="8" y-gap="8">
                        <NGi>
                            <CountUslsWidget />
                        </NGi>
                        <NGi>
                            <CountUslSingle />
                        </NGi>
                    </NGrid>
                </NSpace>
            </NEl>
            <NEl style="background-color: var(--tab-color); padding: 10px 24px 24px 24px; border-radius: 8px;">
                <NSpace vertical>
                    <NH3 style="margin-bottom: 6px; margin-top: 6px;">
                        WEB-МИС
                    </NH3>
                    <NGrid :cols="5" x-gap="8" y-gap="8">
                        <NGi>
                            <MisCountUslsStationar />
                        </NGi>
                        <NGi>
                            <MisCountUslsPolyclinicWidget />
                        </NGi>
                    </NGrid>
                </NSpace>
            </NEl>
        </NFlex>
    </AppLayout>
</template>

<style scoped>

</style>
