export const formatDate = (date) => {
  const formDate = new Date(date)

  const options = {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
  }

  return formDate.toLocaleString('es-MX', options)
}
