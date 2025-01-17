<template>
  <div class="page-container">
    <div class="dashboard-wrapper">
      <div class="dashboard-content">
        <h1 class="dashboard-title">Investment Details</h1>

        <div class="details-container">
          <div class="details-grid">
            <div class="detail-item">
              <p class="detail-label">Original Amount:</p>
              <p class="detail-value">€{{ formatAmount(investment.amount) }}</p>
            </div>
            <div class="detail-item">
              <p class="detail-label">Rounded Amount:</p>
              <p class="detail-value">€{{ formatAmount(investment.rounded_amount) }}</p>
            </div>
            <div class="detail-item">
              <p class="detail-label">Interest Rate:</p>
              <p class="detail-value">{{ investment.interest_rate }}%</p>
            </div>
            <div class="detail-item">
              <p class="detail-label">Start Date:</p>
              <p class="detail-value">{{ formatDate(investment.start_date) }}</p>
            </div>
          </div>

          <h2 class="section-title">Payment Schedule</h2>
          
          <div class="table-container">
            <div class="table-wrapper">
              <table class="investments-table">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="payment in paymentSchedule" :key="payment.id">
                    <td>{{ formatDate(payment.payment_date) }}</td>
                    <td>{{ capitalize(payment.payment_type) }}</td>
                    <td>€{{ formatAmount(payment.interest_amount) }}</td>
                    <td>
                      <span :class="getStatusClass(payment.is_paid)">
                        {{ payment.is_paid ? 'Paid' : 'Pending' }}
                      </span>
                    </td>
                  </tr>
                  <tr v-if="!paymentSchedule.length">
                    <td colspan="4" class="empty-state">
                      No payment schedule available.
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="button-container">
          <router-link
            :to="{ name: 'Investments' }"
            class="back-button"
          >
            Back to Investments
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()

const investment = ref({})
const paymentSchedule = ref([])
const error = ref(null)
const loading = ref(true)

const fetchInvestmentDetails = async () => {
  const investmentId = route.params.id
  if (!investmentId) {
    error.value = 'Investment ID is missing'
    router.push({ name: 'Investments' })
    return
  }

  try {
    const response = await axios.get(`/api/investments/${investmentId}`, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      }
    })
    console.log(response)
    // Correctly access the nested investment data
    investment.value = response.data.data
    paymentSchedule.value = response.data.data.payment_schedules || []
    
  } catch (error) {
    if (error.response?.status === 401) {
      router.push({ name: 'Login' })
    }
    error.value = 'Error fetching investment details'
    console.error('Error fetching investment details:', error)
  } finally {
    loading.value = false
  }
}

const formatAmount = (amount) => {
  return amount ? Number(amount).toFixed(2) : '0.00'
}

const formatDate = (date) => {
  if (!date) return '-'
  return new Date(date).toLocaleDateString()
}

const capitalize = (str) => {
  return str ? str.charAt(0).toUpperCase() + str.slice(1) : ''
}

const getStatusClass = (isPaid) => {
  return isPaid ? 'status-paid' : 'status-pending'
}

onMounted(fetchInvestmentDetails)
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

.details-container {
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  padding: 1.5rem;
  margin-bottom: 2rem;
}

.details-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.detail-item {
  padding: 1rem;
  background-color: #f9fafb;
  border-radius: 0.375rem;
  border: 1px solid #e5e7eb;
}

.detail-label {
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.5rem;
}

.detail-value {
  font-size: 1.125rem;
  color: #111827;
}

.section-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #111827;
  margin: 2rem 0 1rem;
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

.status-paid {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  background-color: #34d399;
  color: white;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 500;
}

.status-pending {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  background-color: #fbbf24;
  color: white;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 500;
}

.button-container {
  text-align: center;
  margin-top: 2rem;
}

.back-button {
  display: inline-flex;
  align-items: center;
  padding: 0.5rem 1rem;
  background-color: #6b7280;
  color: white;
  font-size: 0.875rem;
  font-weight: 500;
  border-radius: 0.375rem;
  border: 1px solid transparent;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
  transition: background-color 0.2s;
}

.back-button:hover {
  background-color: #4b5563;
}

.empty-state {
  text-align: center;
  color: #6b7280;
  padding: 2rem 1.5rem;
}

@media (max-width: 640px) {
  .page-container {
    padding: 0.5rem;
  }

  .dashboard-content {
    padding: 1rem;
  }

  .details-grid {
    grid-template-columns: 1fr;
  }

  .investments-table th,
  .investments-table td {
    padding: 0.75rem 1rem;
  }
}
</style>