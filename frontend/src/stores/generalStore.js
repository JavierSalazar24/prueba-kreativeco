import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useGeneralStore = (storeName, apiService) => {
  return defineStore(storeName, () => {
    const items = ref([])
    const itemToEdit = ref(null)
    const loading = ref(true)
    const mePosts = ref(false)
    const loadingFetch = ref(false)
    const loadingDelete = ref(false)

    const loadMePosts = async () => {
      try {
        items.value = await apiService.getMePosts()
        loading.value = false
        mePosts.value = true
      } catch (error) {
        console.log(error)
      }
    }

    const loadItems = async () => {
      try {
        items.value = await apiService.fetchAll()
        loading.value = false
        mePosts.value = false
      } catch (error) {
        console.log(error)
      }
    }

    const addItem = async (data) => {
      try {
        loadingFetch.value = true
        await apiService.create(data)
        await loadItems()
      } catch (error) {
        console.log(error)
      } finally {
        loadingFetch.value = false
      }
    }

    const editItem = async (data) => {
      try {
        loadingFetch.value = true
        await apiService.update(data)
        await loadItems()
        loadingFetch.value = false
        itemToEdit.value = null
      } catch (error) {
        loadingFetch.value = false
        console.log(error)
      }
    }

    const removeItem = async (id) => {
      try {
        loadingDelete.value = true
        await apiService.delete(id)
        await loadItems()
      } catch (error) {
        console.log(error)
      } finally {
        loadingDelete.value = false
      }
    }

    const resetStore = () => {
      items.value = []
      loading.value = true
    }

    return {
      items,
      itemToEdit,
      loading,
      loadingFetch,
      loadingDelete,
      mePosts,
      loadItems,
      addItem,
      editItem,
      removeItem,
      loadMePosts,
      resetStore,
    }
  })
}
