<template>
  <div class="page-container">
    <div class="dashboard-wrapper">
      <div class="dashboard-content">
        <h1 class="dashboard-title">Manage Investments</h1>
        
        <div class="create-button-container">
          <router-link
            :to="{ name: 'Create' }"
            class="create-button"
          >
            Create your first investment
          </router-link>
        </div>

        <div class="table-container">
          <div class="table-wrapper">
            <table class="investments-table">
              <thead>
                <tr>
                  <th>Amount</th>
                  <th>Interest Rate</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr 
                  v-for="(investment, index) in investments"
                  :key="investment.id"
                  :class="{ 'row-alternate': index % 2 === 0 }"
                >
                  <td>€{{ formatAmount(investment.amount) }}</td>
                  <td>{{ investment.interest_rate }}%</td>
                  <td>{{ formatDate(investment.start_date) }}</td>
                  <td>{{ formatDate(investment.end_date) }}</td>
                  <td class="action-buttons">
                    <button
                      @click="viewInvestment(investment.id)"
                      class="create-button"
                    >
                      View Investment
                    </button>
                  </td>
                </tr>
                <tr v-if="!investments.length">
                  <td colspan="5" class="empty-state">
                    No investments found.
                    <router-link
                      to="/investments/create"
                      class="create-link"
                    >
                      Create your first investment
                    </router-link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const investments = ref([])
const error = ref(null)

const fetchInvestments = async () => {
  try {
   // const token = await axios.get('/sanctum/csrf-cookie')
    const response = await axios.get('/api/investments', {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      }
    })
    investments.value = response.data.data
  } catch (error) {
    if (error.response?.status === 401) {
      console.error('unauthenticated error:', error)
    }
    error.value = 'Error fetching investments'
    console.error('Error fetching investments:', error)
  }
}

const formatAmount = (amount) => {
  return Number(amount).toFixed(2)
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString()
}

const viewInvestment = (id) => {
  router.push({
    name: 'InvestmentDetails',
    params: { id: id }
  })
}

const deleteInvestment = async (id) => {
  try {
    await axios.delete(`/api/investments/${id}`, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      }
    })
    investments.value = investments.value.filter(investment => investment.id !== id)
  } catch (error) {
    console.error('Error deleting investment:', error)
  }
}

onMounted(fetchInvestments)
</script>

<style scoped>
.page-container {
  background-color: #f9fafb;
  padding: 1rem 1rem;
}

.dashboard-wrapper {
  max-width: 2000px;
  margin: 0 auto;
  background-color: white;
  border-radius: 0.5rem;
  min-height: 94vh;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.dashboard-content {
  padding: 2rem;
}

.dashboard-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #111827;
  text-align: center;
  margin-bottom: 2rem;
}

.create-button-container {
  text-align: center;
  margin-bottom: 1.5rem;
}

.create-button {
  display: inline-flex;
  align-items: center;
  padding: 0.5rem 1rem;
  background-color: #2563eb;
  color: white;
  font-size: 0.875rem;
  font-weight: 500;
  border-radius: 0.375rem;
  border: 1px solid transparent;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
  transition: background-color 0.2s;
}

.create-button:hover {
  background-color: #1d4ed8;
}

.table-container {
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  overflow: hidden;
}

.table-wrapper {
  overflow-x: auto;
}

.investments-table {
  width: 100%;
  border-collapse: collapse;
}

.investments-table th {
  padding: 0.75rem 1.5rem;
  text-align: left;
  font-size: 0.75rem;
  font-weight: 500;
  text-transform: uppercase;
  color: #6b7280;
  background-color: #f9fafb;
  border-bottom: 1px solid #e5e7eb;
  letter-spacing: 0.05em;
}

.investments-table td {
  padding: 1rem 1.5rem;
  font-size: 0.875rem;
  color: #111827;
  border-bottom: 1px solid #e5e7eb;
  white-space: nowrap;
}

.investments-table tr:hover {
  background-color: #f9fafb;
  transition: background-color 0.2s;
}

.action-buttons {
  display: flex;
  gap: 1rem;
}

.edit-button {
  color: #2563eb;
  font-weight: 500;
  transition: color 0.2s;
}

.edit-button:hover {
  color: #1d4ed8;
}

.delete-button {
  color: #dc2626;
  font-weight: 500;
  transition: color 0.2s;
}

.delete-button:hover {
  color: #b91c1c;
}

.empty-state {
  text-align: center;
  color: #6b7280;
  padding: 2rem 1.5rem;
}

.create-link {
  color: #25aae1;
  font-weight: 500;
  text-decoration: none;
  transition: color 0.2s;
}

.create-link:hover {
  color: #1d8ecf;
}

@media (max-width: 640px) {
  .page-container {
    padding: 1rem 0.5rem;
  }

  .dashboard-content {
    padding: 1rem;
  }

  .investments-table th,
  .investments-table td {
    padding: 0.75rem 1rem;
  }
}
</style>