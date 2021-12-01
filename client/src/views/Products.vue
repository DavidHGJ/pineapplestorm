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
            >Produtos
            <v-icon>mdi-clipboard-text</v-icon>
          </v-toolbar-title>
          <!-- <v-divider class="mx-4" inset vertical></v-divider> -->
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on }">
              <v-btn color="primary" dark class="mb-2 buttoncolor" v-on="on"
                >Novo Produto</v-btn
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
                        v-model="editedItem.PRD_DESC"
                        label="Descrição do Produto"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="12">
                      <v-select
                        v-model="editedItem.CAT_ID"
                        :items="categoriasCombo"
                        item-text="name"
                        item-value="value"
                        label="Selecionar Categoria"
                        persistent-hint
                        return-object
                        @change="mudarTipoCat(editedItem.CAT_ID)"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="6" md="12">
                      <v-select
                        v-model="editedItem.FOR_ID"
                        :items="fornecedoresCombo"
                        item-text="name"
                        item-value="value"
                        label="Selecionar Fornecedor"
                        persistent-hint
                        return-object
                        @change="mudarTipoFor(editedItem.FOR_ID)"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.PRD_PESO"
                        label="Peso (kg)"
                        v-maska="'#*,##'"
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
        <v-btn color="primary" @click="carregarProdutos">Recarregar</v-btn>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
import api from "../api/api";

export default {
  name: "Products",
  data() {
    return {
      dialog: false,
      headers: [
        { text: "id", value: "PRD_ID" },
        { text: "Descrição", value: "PRD_DESC" },
        { text: "categoria", value: "CAT_DESC" },
        { text: "fornecedor", value: "FOR_NOME" },
        { text: "Peso (kg)", value: "PRD_PESO" },
        { text: "Quantidade", value: "PRD_QTD" },
        { text: "Ações", value: "action", sortable: false, align: "left" },
      ],
      desserts: [],
      categoriasCombo: [],
      fornecedoresCombo: [],
      editedIndex: -1,
      editedItem: {
        PRD_ID: "",
        PRD_DESC: "",
        CAT_ID: "",
        FOR_ID: "",
        PRD_PESO: "",
        PRD_STATUS: "",
      },
      defaultItem: {
        PRD_ID: "",
        PRD_DESC: "",
        CAT_ID: "",
        FOR_ID: "",
        PRD_PESO: "",
        PRD_STATUS: "A",
      },
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Novo Produto" : "Editar Produto";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
  },

  created() {
    this.carregarProdutos();
    this.carregarCategorias();
    this.carregarFornecedores();
  },
  methods: {
    carregarProdutos() {
      api
        .get("/produtos")
        .then((res) => {
          this.desserts = res.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    postProdutos() {
      api
        .post("/produtos", this.editedItem)
        .then(() => {
          alert("Produto cadastrado com sucesso");
          this.carregarProdutos();
        })
        .catch(() => {
          alert("Erro ao cadastrar Produto");
        });
    },

    updateProduto(id) {
      api
        .put(`/produtos/${id}`, this.editedItem)
        .then(() => {
          alert("Produto atualizada com sucesso");
          this.carregarProdutos();
        })
        .catch(() => {
          alert("Erro ao cadastrar Produto");
        });
    },

    deleteProduto(id) {
      api
        .delete(`/produtos/${id}`)
        .then(() => {
          alert("Produto deletada com sucesso");
          this.carregarProdutos();
        })
        .catch(() => {
          alert("Erro ao deletar Produto");
        });
    },

    carregarCategorias() {
      api
        .get("/categoria")
        .then((res) => {
          res.data.data.forEach((element) => {
            const categoria = {
              value: `${element.CAT_ID}`,
              name: `${element.CAT_DESC}`,
            };
            this.categoriasCombo.push(categoria);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },

    carregarFornecedores() {
      api
        .get("/fornecedores")
        .then((res) => {
          res.data.data.forEach((element) => {
            const fornecedor = {
              value: `${element.FOR_ID}`,
              name: `${element.FOR_NOME}`,
            };
            this.fornecedoresCombo.push(fornecedor);
          });
        })
        .catch((error) => {
          console.log(error);
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
      confirm("Tem certeza de que deseja excluir esta Categoria?") &&
        //this.desserts.splice(index, 1);
        this.deleteProduto(idItem.PRD_ID);
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    validaCampos() {
      if (this.editedItem.PRD_DESC == "") return false;
      if (this.editedItem.CAT_ID == "") return false;
      if (this.editedItem.FOR_ID == "") return false;
      if (this.editedItem.PRD_PESO == "") return false;

      return true;
    },

    save() {
      if (this.validaCampos()) {
        this.editedItem.PRD_PESO = this.editedItem.PRD_PESO.replace(",", ".");
        if (this.editedIndex > -1) {
          this.updateProduto(this.editedItem.PRD_ID);
          console.log(this.editedItem);
        } else {
          this.postProdutos(this.editedIndex);
          console.log(this.editedItem);
        }
        this.close();
      } else {
        alert("Favor preencher todos os campos");
      }
    },
    mudarTipoCat(item) {
      this.editedItem.CAT_ID = item.value;
    },
    mudarTipoFor(item) {
      this.editedItem.FOR_ID = item.value;
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