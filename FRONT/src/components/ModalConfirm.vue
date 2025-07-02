<script setup lang="ts">
import ConfirmDialog from "primevue/confirmdialog";
import {useConfirm} from "primevue/useconfirm";

type Props = {
  acceptFn?: (() => void) | undefined,
  message?: string,
  header?: string,
  loading?: boolean,
  group: string
}

const props = withDefaults(defineProps<Props>(), {
  message: `Etes-vous sûr de vouloir vous supprimer votre compte ?`,
  header: 'Suppression',
  loading: false,
})

const confirm = useConfirm()

const callConfirm = () => {
  confirm.require({
    group: props.group,
    message: props.message,
    header: props.header,
    rejectProps: {
      label: 'Annuler',
      severity: 'secondary',
    },
    acceptClass: "buttonFilled",
    rejectClass: "buttonOutlined",
    acceptProps: {
      label: 'Confirmer',
      loading: props.loading,
    },
    accept: props.acceptFn,
    reject: () => {
      return
    }
  })
}


defineExpose({callConfirm})
</script>

<template>
  <ConfirmDialog :group="props.group"></ConfirmDialog>
  <slot></slot>
</template>

<style scoped>
.buttonFilled {
  background-color: var(--primary);
  border: var(--accent);
  color: var(--text);
}

.buttonOutlined {
  border-color: var(--primary);
  color: var(--text);
}
</style>