<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const investment = ref({
  amount: null
});
const errorMessage = ref('');
const loading = ref(false);
const createInvestment = async () => {
  try {
    if (!investment.value.amount || investment.value.amount <= 0) {
      errorMessage.value = 'Amount must be a positive number.';
      return;
    }
    const config = {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${localStorage.getItem('token')}`,
      }
    };

    const response = await axios.post('/api/investments', {
      amount: investment.value.amount
    }, config);

    if (response.data.success) {
      console.log('Investment created successfully:', response.data);
      router.push('/investments');
    }
  } catch (error) {
    console.error('Error:', error.response?.data);
  }
};
</script>

<template>
  <div class="auth-container">
    <div class="form-wrapper">
      <h1 class="text-center text-2xl font-bold mb-6">Create Investment</h1>
      <form @submit.prevent="createInvestment" class="space-y-4">
        <div class="form-group">
          <input 
            v-model="investment.amount" 
            type="number" 
            placeholder="Amount"
            class="input-field"
            required
            step="0.01" 
          />
        </div>
        <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
        <button type="submit" class="submit-button" :disabled="loading">
          {{ loading ? 'Creating...' : 'Create Investment' }}
        </button>
      </form>
    </div>
  </div>
</template>

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
  margin-top: -0.5rem;
}
</style>
