<template>
  <div class="auth-container">
    <div class="form-wrapper">
      <h1 class="text-center text-2xl font-bold mb-6">Login</h1>
      <form @submit.prevent="login" class="space-y-4">
        <div class="form-group">
          <input
            v-model="email"
            type="email"
            placeholder="Email"
            class="input-field"
            required
          />
        </div>
        <div class="form-group">
          <input
            v-model="password"
            type="password"
            placeholder="Password"
            class="input-field"
            required
          />
        </div>
        <button type="submit" class="submit-button">Login</button>
        <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
        <p class="register-link">
          Don't have an account? <router-link to="/register" class="text-blue-500 hover:underline">Register here</router-link>
        </p>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      errorMessage: '',
    };
  },
  methods: {
    async login() {
      try {
        // Attempt to login
        const response = await axios.post('/api/login', {
          email: this.email,
          password: this.password,
        });

        localStorage.setItem('token', response.data.token);
        // Redirect to home page
        this.$router.push('/investments');
        
      } catch (error) {
        // Log and display error
        console.error('Error during login:', error);
        this.errorMessage = 'Login failed: ' + (error.response?.data?.message || 'An error occurred');
      }
    },
  },
};
</script>

<style scoped>
.auth-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f3f4f6;
}

.form-wrapper {
  max-width: 400px;
  width: 100%;
  padding: 2rem;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
  font-size: 2rem;
  color: #333;
}

.form-group {
  margin-bottom: 1rem;

}

.input-field {
  width: 93%;
  padding: 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
  font-size: 1rem;
  transition: border-color 0.3s;
}

.input-field:focus {
  border-color: #4f46e5;
  outline: none;
}

.submit-button {
  width: 100%;
  background-color: #25aae1;
  color: #fff;
  border: none;
  padding: 0.75rem;
  border-radius: 8px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.3s;
  margin-top: 5%;
}

.submit-button:hover {
  background-color: #1d8ecf;
}

.error-message {
  color: #e11d48;
  font-size: 0.875rem;
}

.register-link {
  text-align: center;
  margin-top: 1rem;
}

.register-link a {
  color: #25aae1;
  font-weight: bold;
}
</style>
