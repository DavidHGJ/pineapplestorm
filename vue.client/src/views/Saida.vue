<template>
  <v-container class="pt-15">
    <v-row>
      <v-col lg="6" class="mb-10">
        <h2 class="intro-text">Tela de Saida</h2>
        <div class="mt-10">
          <v-btn to="/Entrada" color="success" class="white--text mr-10" rounded
            >Cadastrar entrada</v-btn
          >
          <v-btn to="/Saida" color="success" class="white--text mr-10" rounded
            >Cadastrar saida</v-btn
          >
        </div>
      </v-col>
      <v-col lg="6">
        <img width="100%" src="./../assets/estoque.png" alt="" />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "Saida",
};
</script>

<style scoped>
h2.intro-text {
  font-size: 60px;
  font-weight: bold;
  color: #444;
}
p.description {
  font-size: 19px;
  margin: 32px 0px;
  color: #444444ba;
}
</style>