<template>
  <v-container>
    <v-data-table
      :headers="headers"
      :items="desserts"
      sort-by="calories"
      class="elevation-1 primary tabela"
    >
      <template v-slot:top>
        <v-toolbar flat color="primary">
          <v-toolbar-title
            >Fornecedores
            <v-icon>mdi-account-circle</v-icon>
          </v-toolbar-title>
          <!-- <v-divider class="mx-4" inset vertical></v-divider> -->
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on }">
              <v-btn color="primary" dark class="mb-2 buttoncolor" v-on="on"
                >Novo Fornecedor</v-btn
              >
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6" md="12">
                      <v-text-field
                        v-model="editedItem.name"
                        label="Nome do Fornecedor"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.weight"
                        label="Peso em KG"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.amount"
                        label="Quantidade"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close"
                  >Cancelar</v-btn
                >
                <v-btn color="blue darken-1" text @click="save">Salvar</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:[`item.action`]="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)"> Editar </v-icon>
        <v-icon small @click="deleteItem(item)"> Deletar </v-icon>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize">Resetar</v-btn>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
export default {
  name: "Fornecedores",
  data() {
    return {
      dialog: false,
      headers: [
        { text: "Nome", value: "name" },
        { text: "Peso", value: "weight" },
        { text: "Quantidade", value: "amount" },
        { text: "Ações", value: "action", sortable: false, align: "left" },
      ],
      desserts: [],
      editedIndex: -1,
      editedItem: {
        name: "",
        weight: 0,
        amount: 0,
      },
      defaultItem: {
        name: "",
        weight: 0,
        amount: 0,
      },
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Novo Fornecedor" : "Editar Fornecedor";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
  },

  created() {
    this.initialize();
  },
  methods: {
    initialize() {
      this.desserts = [
        {
          name: "Motor caminhão Volvo Classe 8",
          weight: 1213,
          amount: 10,
        },
        {
          name: "Motor caminhão Volvo Classe 8 Antigo",
          weight: 1520,
          amount: 5,
        },
        {
          name: "Motor caminhão Tesla ",
          weight: 2123,
          amount: 3,
        },
        {
          name: "Turbina de avião Tam",
          weight: 5000,
          amount: 2,
        },
      ];
    },

    editItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.desserts.indexOf(item);
      confirm("Tem certeza de que deseja excluir este item?") &&
        this.desserts.splice(index, 1);
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.desserts[this.editedIndex], this.editedItem);
      } else {
        this.desserts.push(this.editedItem);
      }
      this.close();
    },
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

.tabela {
  border-radius: 2em;
  margin-left: 15px;
  box-shadow: 5px 5px 5px 5px #101519; /*any color you want*/
}
.buttoncolor {
  background-color: "#ffb500";
}
</style>