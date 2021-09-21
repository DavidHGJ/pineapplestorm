<template>
  <v-container>
    <v-data-table
      :headers="headers"
      :items="fornecedores"
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
                        v-model="editedItem.nome"
                        label="Nome do Fornecedor"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.numero"
                        label="Numero"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.cep"
                        label="CEP"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.cnpj"
                        label="CNPJ"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.insc"
                        label="INSC"
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
        { text: "Nome", value: "nome" },
        { text: "Numero", value: "numero" },
        { text: "CEP", value: "cep" },
        { text: "CNPJ", value: "cnpj" },
        { text: "INSC", value: "insc" },
        { text: "Ações", value: "action", sortable: false, align: "left" },
      ],
      fornecedores: [],
      editedIndex: -1,
      editedItem: {
        nome: "",
        numero: 0,
        cep: 0,
        cnpj: 0,
        insc: 0,
      },
      defaultItem: {
        nome: "",
        numero: 0,
        cep: 0,
        cnpj: 0,
        insc: 0,
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
      this.fornecedores = [
        {
          nome: "Fornecedor a",
          numero: 123,
          cep: 13386042,
          cnpj: 12345678910112,
          insc: 123456,
        },
        {
          nome: "Fornecedor b",
          numero: 123,
          cep: 13386042,
          cnpj: 12345678910112,
          insc: 123456,
        },
        {
          nome: "Fornecedor c",
          numero: 123,
          cep: 13386042,
          cnpj: 12345678910112,
          insc: 123456,
        },
        {
          nome: "Fornecedor d",
          numero: 123,
          cep: 13386042,
          cnpj: 12345678910112,
          insc: 123456,
        },
        {
          nome: "Fornecedor e",
          numero: 123,
          cep: 13386042,
          cnpj: 12345678910112,
          insc: 123456,
        },
        {
          nome: "Fornecedor f",
          numero: 123,
          cep: 13386042,
          cnpj: 12345678910112,
          insc: 123456,
        },
        {
          nome: "Fornecedor g",
          numero: 123,
          cep: 13386042,
          cnpj: 12345678910112,
          insc: 123456,
        },
      ];
    },

    editItem(item) {
      this.editedIndex = this.fornecedores.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.fornecedores.indexOf(item);
      confirm("Tem certeza de que deseja excluir este item?") &&
        this.fornecedores.splice(index, 1);
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
        Object.assign(this.fornecedores[this.editedIndex], this.editedItem);
      } else {
        this.fornecedores.push(this.editedItem);
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