import { ref, watch, computed } from 'vue'

export function useFormHandler(props, emit) {
  const form = ref({})
  const errorsMessage = ref({})

  const resetForm = () => {
    form.value = props.entityToEdit
      ? Object.assign({}, props.entityToEdit)
      : Object.fromEntries(props.fields.map(({ name, default: def = '' }) => [name, def]))
  }

  watch(() => props.entityToEdit, resetForm, { immediate: true })

  const handleSubmit = async () => {
    errorsMessage.value = {}

    const validationResult = props.validationSchema.safeParse(form.value)
    if (!validationResult.success) {
      const errors = validationResult.error.format()
      errorsMessage.value = Object.fromEntries(
        Object.entries(errors).map(([key, val]) => [key, val?._errors?.[0] || '']),
      )
      return
    }

    emit('submit', { ...form.value, id: props.entityToEdit?.id })
    resetForm()
  }

  const formTitle = computed(() => `${props.entityToEdit ? 'Edit' : 'Create'} ${props.title}`)

  const handleCancel = () => emit('cancel')

  return { form, errorsMessage, resetForm, handleSubmit, handleCancel, formTitle }
}
