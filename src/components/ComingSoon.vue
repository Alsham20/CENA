<template>
  <div class="coming-soon">
    <div class="icon">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
      </svg>
    </div>
    <h1>Bientôt disponible</h1>
    <p>Cette rubrique est en cours de préparation et sera disponible prochainement.</p>
    <router-link to="/" class="back-home">Revenir à l'accueil</router-link>
  </div>
</template>

<script lang="ts">
export default {
  name: "ComingSoon",
};
</script>

<style scoped>
.coming-soon {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100vh;
  text-align: center;
  background-color: #ffffff;
  color: #333;
}

.icon {
  width: 120px;
  height: 120px;
  color: #11845a;
  margin-bottom: 1rem;
}

.icon svg {
  width: 100%;
  height: 100%;
}

.coming-soon h1 {
  font-size: 2.5rem;
  font-weight: 600;
  margin: 0;
  color: #11845a;
}

.coming-soon p {
  font-size: 1.25rem;
  margin: 1rem 0;
  max-width: 400px;
  color: #666;
}

.back-home {
  margin-top: 2rem;
  padding: 0.75rem 1.5rem;
  background-color: #0E6258;
  color: white;
  text-decoration: none;
  font-weight: 500;
  transition: background-color 0.3s ease;
}

.back-home:hover {
  background-color: #11845a;
}
</style>
