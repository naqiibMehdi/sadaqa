<script setup lang="ts">
import ConfirmDialog from "primevue/confirmdialog";
import {useConfirm} from "primevue/useconfirm";

type Props = {
  acceptFn?: (() => void) | undefined,
  message?: string,
  header?: string,
  group: string
}

const props = withDefaults(defineProps<Props>(), {
  message: `Etes-vous sûr de vouloir vous supprimer votre compte ?\nCela mènera à la perte de toutes vos informations (données personnelles, cagnottes et don des participants)`,
  header: 'Suppression'
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
      label: 'Confirmer'
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