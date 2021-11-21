<template>
  <v-container class="content">
    <h2 class="intro-text">Sistema de controle de estoque</h2>
    <div class="mt-10">
      <v-btn to="/Entrada" color="buttoncolor" class="white--text mr-10" rounded
        >Cadastrar entrada</v-btn
      >
      <v-btn
        to="/Saida"
        color="buttoncolor"
        class="white--text mr-10 mt-5"
        rounded
        >Cadastrar saida</v-btn
      >
    </div>
    <v-col lg="6">
      <img
        width="100%"
        src="./../assets/estoque.png"
        class="position: absolute"
      />
    </v-col>
  </v-container>

  <!-- <v-container>
      <v-row dense>
        <v-col v-for="(item, i) in headers" :key="i" cols="3">
          <v-card :color="item.color" dark>
            <div class="d-flex flex-no-wrap justify-space-between">
              <div>
                <v-card-title
                  class="text-h5"
                  v-text="item.title"
                ></v-card-title>

                <v-card-subtitle v-text="item.artist"></v-card-subtitle>
              </div>

              <v-avatar class="ma-3" size="125" tile>
                <v-icon size="125">{{ item.icon }}</v-icon>
              </v-avatar>
            </div>
          </v-card>
        </v-col>
      </v-row>
    </v-container> -->

  <!-- <v-container>
      <v-row dense>
        <v-col v-for="(item, i) in card1" :key="i" cols="6">
          <v-card :color="item.color" dark height="400px">
            <div class="d-flex flex-no-wrap justify-space-between">
              <div>
                <v-card-title
                  class="text-h5"
                  v-text="item.title"
                ></v-card-title>

                <v-icon size="300">{{ item.icon }}</v-icon>
              </div>
              <div class="mt-16">
                <h1>Entrada x Saida</h1>
                <h2>Entrada: 20</h2>
                <h2>Saida: 15</h2>
              </div>

              <v-avatar class="ma-3" size="125" tile>
              </v-avatar>
            </div>
          </v-card>
        </v-col>
        <v-col v-for="(item, i) in card2" :key="i" cols="6">
          <v-card :color="item.color" dark height="400px">
            <div class="d-flex flex-no-wrap justify-space-between">
              <div>
                <v-card-title
                  class="text-h5"
                  v-text="item.title"
                ></v-card-title>

                <v-icon size="300">{{ item.icon1 }}</v-icon>
              </div>
              <div class="mt-16 ml-16">
                <v-icon size="300">{{ item.icon2 }}</v-icon>
              </div>

              <v-avatar class="ma-3" size="125" tile>
              </v-avatar>
            </div>
          </v-card>
        </v-col>
      </v-row>
    </v-container> -->

  <!-- <v-container>
      <v-row dense>
        <v-col v-for="(item, i) in footer" :key="i" cols="4 ">
          <v-card :color="item.color" dark height="290px">
            <div class="d-flex flex-no-wrap justify-space-between">
              <div>
                <v-card-title
                  class="text-h5"
                  v-text="item.title"
                ></v-card-title>

                <v-icon size="200">{{ item.icon }}</v-icon>
              </div>

              <v-avatar class="ma-3" size="125" tile>
              </v-avatar>
            </div>
          </v-card>
        </v-col>
      </v-row>
    </v-container> -->
</template>

<script>
export default {
  name: "TelaInicial",
  data() {
    return {
      headers: [
        {
          color: "primary",
          icon: "mdi-food-apple",
          title: "Produto 1",
          artist: "Quantidade em estoque: 10",
        },
        {
          color: "primary",
          icon: "mdi-food-apple",
          title: "Produto 2",
          artist: "Quantidade em estoque: 20",
        },
        {
          color: "primary",
          icon: "mdi-food-apple",
          title: "Produto 3",
          artist: "Quantidade em estoque: 30",
        },
        {
          color: "primary",
          icon: "mdi-food-apple",
          title: "Produto 4",
          artist: "Quantidade em estoque: 40",
        },
      ],
      card1: [
        {
          color: "primary",
          icon: "mdi-chart-line",
          title: "Faturamento de impacto",
        },
      ],
      card2: [
        {
          color: "primary",
          icon1: "mdi-google-analytics",
          icon2: "mdi-earth",
          title: "Análise regional",
        },
      ],
      footer: [
        {
          color: "primary",
          icon: "mdi-google-analytics",
          title: "Produto A",
          artist: "Quantidade em estoque: 10",
        },
        {
          color: "primary",
          icon: "mdi-google-analytics",
          title: "Produto B",
          artist: "Quantidade em estoque: 20",
        },
        {
          color: "primary",
          icon: "mdi-google-analytics",
          title: "Produto C",
          artist: "Quantidade em estoque: 20",
        },
      ],
    };
  },
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
.content {
  width: 70vw;
  height: 70vh;
  display: flex;
  align-items: center;
}
</style>