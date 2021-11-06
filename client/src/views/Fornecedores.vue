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
            <v-icon>mdi-home-outline</v-icon>
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
                        v-model="editedItem.FOR_NOME"
                        label="Nome do Fornecedor"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.FOR_CNPJ"
                        label="CNPJ"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.FOR_INSC"
                        label="INSC"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.FOR_CEP"
                        label="CEP"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.FOR_NUM"
                        label="NUMERO"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.FOR_COMPLEMENTO"
                        label="COMPLEMENTO"
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
        <v-btn color="primary" @click="carregarFornecedor">Resetar</v-btn>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
import api from "../api/api";

export default {
  name: "Fornecedores",
  data() {
    return {
      dialog: false,
      headers: [
        { text: "id", value: "FOR_ID" },
        { text: "Descrição", value: "FOR_NOME" },
        { text: "CNPJ", value: "FOR_CNPJ" },
        { text: "INSC", value: "FOR_INSC" },
        { text: "Cep", value: "FOR_CEP" },
        { text: "Numero", value: "FOR_NUM" },
        { text: "Complemento", value: "FOR_COMPLEMENTO" },
        { text: "Ações", value: "action", sortable: false, align: "left" },
      ],
      desserts: [],
      editedIndex: -1,
      editedItem: {
        FOR_NOME: "",
        FOR_NUM: "",
        FOR_CEP: "",
        FOR_CNPJ: "",
        FOR_INSC: "",
        FOR_STATUS: "",
        FOR_COMPLEMENTO: "",
      },
      defaultItem: {
        FOR_NOME: "",
        FOR_NUM: "",
        FOR_CEP: "",
        FOR_CNPJ: "",
        FOR_INSC: "",
        FOR_STATUS: "",
        FOR_COMPLEMENTO: "",
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
    this.carregarFornecedor();
  },
  methods: {
    carregarFornecedor() {
      api
        .get("/fornecedores")
        .then((res) => {
          this.desserts = res.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    postFornecedor() {
      console.log(this.editedItem);
      api
        .post("/Fornecedor", this.editedItem)
        .then(() => {
          alert("Fornecedor cadastrada com sucesso");
          this.carregarFornecedor();
        })
        .catch(() => {
          alert("Erro ao cadastrar Fornecedor");
        });
    },

    updateFornecedor(id) {
      api
        .put(`/Fornecedor/${id}`, this.editedItem)
        .then(() => {
          alert("Fornecedor atualizada com sucesso");
          this.carregarFornecedor();
        })
        .catch(() => {
          alert("Erro ao cadastrar Fornecedor");
        });
    },

    deleteUser(id) {
      console.log(id);
      api
        .delete(`/Fornecedor/${id}`)
        .then(() => {
          alert("Fornecedor deletada com sucesso");
          this.carregarFornecedor();
        })
        .catch(() => {
          alert("Erro ao deletar Fornecedor");
        });
    },

    editItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      const idItem = Object.assign({}, item);
      confirm("Tem certeza de que deseja excluir este fornecedor?") &&
        //this.desserts.splice(index, 1);
        this.deleteUser(idItem.TRS_ID);
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
        this.updateFornecedor(this.editedIndex);
      } else {
        this.postFornecedor(this.editedIndex);
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