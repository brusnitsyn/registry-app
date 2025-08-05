import {createDiscreteApi, darkTheme, lightTheme} from "naive-ui";
import {useLocalStorage} from "@vueuse/core";

export const useMessage = () => {
    const theme = useLocalStorage('theme', 'dark')

    const configProviderPropsRef = computed(() => ({
        theme: theme.value === 'light' ? lightTheme : darkTheme
    }))

    const { message } = createDiscreteApi(
        ['message'],
        {
            configProviderProps: configProviderPropsRef
        }
    )

    return message
}
