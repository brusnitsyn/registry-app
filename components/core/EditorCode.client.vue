<script setup lang="ts">
import xmlFormat from 'xml-formatter'
import EditorJS from "@editorjs/editorjs"
import editorjsCodecup from '@calumk/editorjs-codecup'

const props = defineProps({
  code: String
})

function OBJtoXML(obj) {
  let xml = '';
  for (let prop in obj) {
    if (obj[prop] == null) continue
    xml += obj[prop] instanceof Array ? '' : "<" + prop.toUpperCase() + ">";
    if (obj[prop] instanceof Array) {
      for (let array in obj[prop]) {
        xml += "<" + prop.toUpperCase() + ">";
        xml += OBJtoXML(new Object(obj[prop][array]));
        xml += "</" + prop.toUpperCase() + ">";
      }
    } else if (typeof obj[prop] == "object") {
      xml += OBJtoXML(new Object(obj[prop]));
    } else {
      xml += obj[prop];
    }
    xml += obj[prop] instanceof Array ? '' : "</" + prop.toUpperCase() + ">";
  }
  xml = xml.replace(/<\/?[0-9]{1,}>/g, '');
  return xml
}

const editor = ref<EditorJS>(null)

const formatedXml = computed(() => {
  const obj2xml = OBJtoXML(props.code)
  const xml = xmlFormat(obj2xml, {
    collapseContent: true
  })

  return xml
})

onMounted(() => {
  editor.value = new EditorJS({
    holder: 'editor-code',
    readOnly: true,
    tools: {
      code: {
        class: editorjsCodecup,
      },
    },
    data: {
      blocks: [
        {
          type: 'code',
          data: {
            code: formatedXml.value,
            language: "XML"
          }
        }
      ]
    },
  })
})
</script>

<template>
  <div id="editor-code" />
</template>

<style scoped>
:deep(.editorjs-codeCup_Wrapper) {
  @apply !h-[93vh] overflow-hidden;
}

:deep(.codecup__copyButton) {
  @apply right-5;
}

:deep(.editorjs-codeCup_LangDisplay) {
  @apply hidden;
}

:deep(.editorjs-codeCup_LangDisplay) {
  @apply px-4 pb-6;
}
</style>