import { apiService } from './config'

export const fetchPosts = () => apiService.get('posts/get_posts.php')
export const fetchMePosts = () => apiService.get('posts/get_me_posts.php')
export const createPost = (post) => apiService.post('posts/create_post.php', post)
export const updatePost = (post) => apiService.put('posts/update_post.php', post)
export const deletePost = (id) => apiService.delete('posts/delete_post.php', id)
