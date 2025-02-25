import { apiService } from './config'

export const fetchPosts = () => apiService.get('posts')
export const fetchMePosts = () => apiService.get('posts?me=true')
export const createPost = (post) => apiService.post('posts', post)
export const updatePost = (post) => apiService.put('posts', post)
export const deletePost = (id) => apiService.delete('posts', id)
