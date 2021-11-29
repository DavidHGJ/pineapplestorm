<template>
  <v-container>
    <v-data-table
      hide-default-footer
      disable-pagination
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
                        v-model="editedItem.FOR_NOME"
                        label="Nome do Fornecedor"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="editedItem.FOR_CNPJ"
                        label="CNPJ"
                        v-maska="'##.###.###/####-##'"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.FOR_INSC"
                        label="INSC"
                        v-maska="'###.###.###.###'"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.FOR_CEP"
                        label="CEP"
                        v-maska="'#####-###'"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.FOR_NUMERO"
                        label="NUMERO"
                        v-maska="'#####'"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="8">
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
        <v-icon small class="mr-2" @click="deleteItem(item)"> Deletar </v-icon>
        <v-icon small @click="abrirContatos(item)"> Contatos </v-icon>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="carregarFornecedor">Resetar</v-btn>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
import api from "../api/api";
import { mask } from "maska";
import { cnpjValidation } from "../../js/cnpj.validation";

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
        { text: "Numero", value: "FOR_NUMERO" },
        { text: "Complemento", value: "FOR_COMPLEMENTO" },
        { text: "Ações", value: "action", sortable: false, align: "left" },
      ],
      desserts: [],
      editedIndex: -1,
      editedItem: {
        FOR_NOME: "",
        FOR_NUMERO: "",
        FOR_CEP: "",
        FOR_CNPJ: "",
        FOR_INSC: "",
        FOR_STATUS: "",
        FOR_COMPLEMENTO: "",
      },
      defaultItem: {
        FOR_NOME: "",
        FOR_NUMERO: "",
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
          this.desserts.forEach((element) => {
            element.FOR_CNPJ = mask(element.FOR_CNPJ, "##.###.###/####-##");
            element.FOR_INSC = mask(element.FOR_INSC, "###.###.###.###");
            element.FOR_CEP = mask(element.FOR_CEP, "#####-###");
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },

    postFornecedor() {
      api
        .post("/fornecedores", this.removeMask(this.editedItem))
        .then(() => {
          alert("Fornecedor adicionado com sucesso");
          this.carregarFornecedor();
        })
        .catch(() => {
          alert("Erro ao cadastrar Fornecedor");
        });
    },

    updateFornecedor(id) {
      api
        .put(`/fornecedores/${id}`, this.removeMask(this.editedItem))
        .then(() => {
          alert("Fornecedor atualizada com sucesso");
          this.carregarFornecedor();
        })
        .catch(() => {
          alert("Erro ao cadastrar Fornecedor");
        });
    },

    deleteUser(id) {
      api
        .delete(`/fornecedores/${id}`)
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
        this.deleteUser(idItem.FOR_ID);
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    save() {
      if (this.validaCnpj(this.editedItem.FOR_CNPJ)) {
        if (this.editedIndex > -1) {
          this.updateFornecedor(this.editedItem.FOR_ID);
        } else {
          this.postFornecedor(this.editedIndex);
        }
        this.close();
      } else {
        alert("CNPJ Inválido!!");
      }
    },

    validaCnpj(cnpj) {
      return cnpjValidation(cnpj);
    },

    removeMask(item) {
      item.FOR_CNPJ = item.FOR_CNPJ.replace(/[^0-9]/g, "");
      item.FOR_INSC = item.FOR_INSC.replace(/[^0-9]/g, "");
      item.FOR_CEP = item.FOR_CEP.replace(/[^0-9]/g, "");
      item.FOR_STATUS = "A";
      return item;
    },

    abrirContatos(item) {
      this.$router.push({
        path: `/ContatoFornecedores/${item.FOR_ID}`,
      }); // -> /user/123
    },

    validaCampos() {
      if (this.editedItem.FOR_DESC == "") return false;
      if (this.editedItem.FOR_CNPJ == "") return false;
      if (this.editedItem.FOR_CEP == "") return false;
      if (this.editedItem.FOR_NUM == "") return false;
      if (this.editedItem.FOR_COMPLEMENTO == "") return false;
      return true;
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
  margin-left: 15px;
  box-shadow: 5px 5px 5px 5px #101519; /*any color you want*/
}
.buttoncolor {
  background-color: "#ffb500";
}
</style>