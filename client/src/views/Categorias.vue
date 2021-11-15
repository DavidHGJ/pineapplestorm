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
            >Categorias
            <v-icon>mdi-clipboard-edit-outline</v-icon>
          </v-toolbar-title>
          <!-- <v-divider class="mx-4" inset vertical></v-divider> -->
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on }">
              <v-btn color="primary" dark class="mb-2 buttoncolor" v-on="on"
                >Nova Categoria</v-btn
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
                        v-model="editedItem.CAT_DESC"
                        label="Nome da Categoria"
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
        <v-btn color="primary" @click="carregarCategoria">Resetar</v-btn>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
import api from "../api/api";

export default {
  name: "Categorias",
  data() {
    return {
      dialog: false,
      headers: [
        { text: "id", value: "CAT_ID" },
        { text: "Descrição", value: "CAT_DESC" },
        { text: "Ações", value: "action", sortable: false, align: "left" },
      ],
      desserts: [],
      editedIndex: -1,
      editedItem: {
        CAT_DESC: "",
        CAT_STATUS: "",
      },
      defaultItem: {
        CAT_DESC: "",
        CAT_STATUS: "",
      },
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nova Categoria" : "Editar Categoria";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
  },

  created() {
    this.carregarCategoria();
  },
  methods: {
    carregarCategoria() {
      api
        .get("/categoria")
        .then((res) => {
          this.desserts = res.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    postCategoria() {
      console.log(this.editedItem);
      api
        .post("/categoria", this.addStatus(this.editedItem))
        .then(() => {
          alert("Categoria cadastrada com sucesso");
          this.carregarCategoria();
        })
        .catch(() => {
          alert("Erro ao cadastrar Categoria");
        });
    },

    updateCategoria(id) {
      api
        .put(`/categoria/${id}`, this.editedItem)
        .then(() => {
          alert("Categoria atualizada com sucesso");
          this.carregarCategoria();
        })
        .catch(() => {
          alert("Erro ao cadastrar Categoria");
        });
    },

    deleteUser(id) {
      console.log(id);
      api
        .delete(`/categoria/${id}`)
        .then(() => {
          alert("Categoria deletada com sucesso");
          this.carregarCategoria();
        })
        .catch(() => {
          alert("Erro ao deletar Categoria");
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
        this.deleteUser(idItem.CAT_ID);
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
        this.updateCategoria(this.editedItem.CAT_ID);
      } else {
        this.postCategoria(this.editedIndex);
      }
      this.close();
    },
    addStatus(item) {
      item.CAT_STATUS = "A";
      return item;
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