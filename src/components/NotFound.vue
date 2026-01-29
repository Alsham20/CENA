
<template>
  <div class="not-found">
    <h1>404</h1>
    <p>Oups! La page que vous recherchez n'existe pas.</p>
    <router-link to="/" class="back-home">Revenir à l'accueil</router-link>
  </div>
</template>

<script lang="ts">
export default {
  name: "NotFound",
};
</script>

<style scoped>
.not-found {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100vh;
  text-align: center;
  background-color: #ffffff;
  color: #333;
}

.not-found h1 {
  font-size: 8rem;
  margin: 0;
  color: #11845a;
}

.not-found p {
  font-size: 1.5rem;
  margin: 1rem 0;
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

h1{
  font-weight: 600;
  font-size: 2rem;
}
</style>