import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useGeneralStore = (storeName, apiService) => {
  return defineStore(storeName, () => {
    const items = ref([])
    const itemToEdit = ref(null)
    const loading = ref(true)
    const mePosts = ref(true)

    const loadMePosts = async () => {
      try {
        items.value = await apiService.getMePosts()
        loading.value = false
        mePosts.value = false
      } catch (error) {
        console.log(error)
      }
    }

    const loadItems = async () => {
      try {
        items.value = await apiService.fetchAll()
        loading.value = false
        mePosts.value = true
      } catch (error) {
        console.log(error)
      }
    }

    const addItem = async (data) => {
      try {
        await apiService.create(data)
        await loadItems()
      } catch (error) {
        console.log(error)
      }
    }

    const editItem = async (data) => {
      try {
        await apiService.update(data)
        itemToEdit.value = null
        await loadItems()
      } catch (error) {
        console.log(error)
      }
    }

    const removeItem = async (id) => {
      try {
        await apiService.delete(id)
        await loadItems()
      } catch (error) {
        console.log(error)
      }
    }

    return {
      items,
      itemToEdit,
      loading,
      mePosts,
      loadItems,
      addItem,
      editItem,
      removeItem,
      loadMePosts,
    }
  })
}
