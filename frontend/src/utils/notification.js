import iziToast from 'izitoast'

export const notification = (message, type) => {
  iziToast[type]({
    message: message,
    timeout: 2000,
  })
}
