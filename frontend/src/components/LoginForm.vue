<script setup>
import { useLoginForm } from '@/composables/useLoginForm'

const { email, password, errorsMessage, handleLogin, loading } = useLoginForm()
</script>

<template>
  <main class="login-container">
    <section class="login-form">
      <h2>Login</h2>
      <form @submit.prevent="handleLogin" autocomplete="off">
        <div class="form-group">
          <label for="email">Email:</label>
          <input
            type="email"
            id="email"
            v-model="email"
            required
            placeholder="example@example.com"
          />
          <span class="error-message" v-if="errorsMessage.email">{{ errorsMessage.email }}</span>
        </div>

        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="password" required placeholder="********" />
          <span class="error-message" v-if="errorsMessage.password">{{
            errorsMessage.password
          }}</span>
        </div>

        <button type="submit" :disabled="loading">{{ loading ? 'Loading...' : 'Log In' }}</button>
      </form>
    </section>
  </main>
</template>

<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #09090a;
  font-family: Arial, sans-serif;
  margin-top: 2rem;
}

.login-form {
  background-color: #18181a;
  padding: 2rem;
  border-radius: 8px;
  width: 100%;
  max-width: 500px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

h2 {
  color: #e21e60;
  margin-bottom: 1.5rem;
  text-align: center;
}

.form-group {
  margin-bottom: 1rem;
  display: flex;
  flex-direction: column;
}

label {
  display: block;
  margin-bottom: 0.5rem;
  color: #b1b1b1;
}

input[type='email'],
input[type='password'] {
  padding: 0.75rem;
  background-color: #18181a;
  border: 1px solid #38383b;
  border-radius: 4px;
  color: #ffffff;
  font-size: 1rem;
}

input[type='email']:focus,
input[type='password']:focus {
  outline: none;
  border-color: #e21e60;
}

input:disabled {
  background-color: #797979;
  color: #b8b8b8;
}

button {
  width: 100%;
  padding: 0.75rem;
  background-color: #bd1a50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #8d153d;
}

button:disabled,
button:disabled:hover {
  background-color: #b8607d;
  color: #ddcccc;
  cursor: auto;
}

.error-message {
  color: #e53e3e;
  font-size: 0.875rem;
  margin-top: 0.25rem;
}
</style>
