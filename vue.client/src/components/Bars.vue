<template>
  <div id="app">
    <v-app
      id="inspire"
      :style="{ background: $vuetify.theme.themes[theme].background }"
    >
      <!-- <v-app-bar app color="success">
        <v-spacer></v-spacer>
      </v-app-bar> -->
      <v-navigation-drawer app class="navbar" color="#262b2f">
        <v-list-item link to="/">
          <v-list-item-content>
            <v-list-item-title class="text-h6">
              Pineapple Site
            </v-list-item-title>
            <v-list-item-subtitle> controle de estoque </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list>
          <v-list-item
            v-for="item in items"
            :key="item.title"
            link
            :to="item.href"
          >
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>

        <template v-slot:append>
          <div class="pa-2 mb-7">
            <v-btn block> Sair </v-btn>
          </div>
        </template>
      </v-navigation-drawer>
      <v-content>
        <v-container fluid fill-height>
          <v-layout>
            <router-view>
              <!-- Todo o conteudo do site será renderizado dentro dessa tag -->
            </router-view>
          </v-layout>
        </v-container>
      </v-content>
    </v-app>
  </div>
</template>

<script>
export default {
  name: "Bars",
  data() {
    return {
      items: [
        { title: "Produtos", href: "Products", icon: "mdi-clipboard-text" },
        { title: "Entrada", href: "Entrada", icon: "mdi-truck" },
        { title: "Saida", href: "Saida", icon: "mdi-truck-delivery" },
      ],
    };
  },
  computed: {
    theme() {
      return this.$vuetify.theme.dark ? "dark" : "light";
    },
  },
};
</script>

<style>
.navbar {
  border-radius: 10px 10px 30px;
  margin-top: 23px;
  margin-left: 15px;
  box-shadow: 5px 5px 5px 5px #101519; /*any color you want*/
}
</style>