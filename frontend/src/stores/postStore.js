import { fetchPosts, createPost, updatePost, deletePost, fetchMePosts } from '@/api/requestPost'
import { useGeneralStore } from './generalStore'

export const usePostStore = useGeneralStore('post', {
  getMePosts: fetchMePosts,
  fetchAll: fetchPosts,
  create: createPost,
  update: updatePost,
  delete: deletePost,
})
