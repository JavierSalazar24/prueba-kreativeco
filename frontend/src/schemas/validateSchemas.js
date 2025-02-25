import { z } from 'zod'

export const loginSchema = z.object({
  email: z.string().email('Invalid email address').nonempty('Email is required'),
  password: z
    .string()
    .min(8, 'Password must be at least 8 characters long')
    .nonempty('Password is required'),
})

export const postSchema = z.object({
  title: z
    .string()
    .min(3, 'Title must be at least 3 characters long')
    .max(100, 'Title cannot exceed 100 characters'),
  description: z
    .string()
    .min(5, 'Description must be at least 5 characters long')
    .max(500, 'Description cannot exceed 500 characters'),
})

export const roleSchema = z.object({
  name: z
    .string()
    .min(3, 'Name must be at least 3 characters long')
    .max(100, 'Name cannot exceed 100 characters'),
})

export const registerSchema = z.object({
  name: z
    .string()
    .min(3, 'Name must be at least 3 characters long')
    .max(100, 'Name cannot exceed 50 characters'),
  last_name: z
    .string()
    .min(3, 'Last name must be at least 3 characters long')
    .max(100, 'Last name cannot exceed 50 characters'),
  email: z.string().email('Invalid email address').nonempty('Email is required'),
  password: z
    .string()
    .min(8, 'Password must be at least 8 characters long')
    .nonempty('Password is required'),
})

export const updateUserSchema = z.object({
  name: z
    .string()
    .min(3, 'Name must be at least 3 characters long')
    .max(100, 'Name cannot exceed 50 characters'),
  last_name: z
    .string()
    .min(3, 'Last name must be at least 3 characters long')
    .max(100, 'Last name cannot exceed 50 characters'),
})
