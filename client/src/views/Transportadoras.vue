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
            >Transportadoras
            <v-icon>mdi-truck</v-icon>
          </v-toolbar-title>
          <!-- <v-divider class="mx-4" inset vertical></v-divider> -->
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on }">
              <v-btn color="primary" dark class="mb-2 buttoncolor" v-on="on"
                >Nova Transportadora</v-btn
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
                        v-model="editedItem.TRS_DESC"
                        label="Nome da Transportadora"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="editedItem.TRS_CNPJ"
                        label="CNPJ"
                        v-maska="'##.###.###/####-##'"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.TRS_INSC"
                        label="INSC"
                        v-maska="'###.###.###.###'"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.TRS_CEP"
                        label="CEP"
                        v-maska="'#####-###'"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.TRS_NUM"
                        label="NUMERO"
                        v-maska="'#########'"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="8">
                      <v-text-field
                        v-model="editedItem.TRS_COMPLEMENTO"
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
        <v-btn color="primary" @click="carregarTransportadora">Resetar</v-btn>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
import api from "../api/api";
import { mask } from "maska";

export default {
  name: "Transportadoras",
  data() {
    return {
      dialog: false,
      headers: [
        { text: "id", value: "TRS_ID" },
        { text: "Descrição", value: "TRS_DESC" },
        { text: "CNPJ", value: "TRS_CNPJ" },
        { text: "INSC", value: "TRS_INSC" },
        { text: "Cep", value: "TRS_CEP" },
        { text: "Numero", value: "TRS_NUM" },
        { text: "Complemento", value: "TRS_COMPLEMENTO" },
        { text: "Ações", value: "action", sortable: false, align: "left" },
      ],
      desserts: [],
      editedIndex: -1,
      editedItem: {
        TRS_DESC: "",
        TRS_NUM: "",
        TRS_CEP: "",
        TRS_CNPJ: "",
        TRS_INSC: "",
        TRS_STATUS: "",
        TRS_COMPLEMENTO: "",
      },
      defaultItem: {
        TRS_DESC: "",
        TRS_NUM: "",
        TRS_CEP: "",
        TRS_CNPJ: "",
        TRS_INSC: "",
        TRS_STATUS: "",
        TRS_COMPLEMENTO: "",
      },
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1
        ? "Nova Transportadora"
        : "Editar Transportadora";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
  },

  created() {
    this.carregarTransportadora();
  },
  methods: {
    carregarTransportadora() {
      api
        .get("/transportadora")
        .then((res) => {
          this.desserts = res.data.data;
          this.desserts.forEach((element) => {
            element.TRS_CNPJ = mask(element.TRS_CNPJ, "##.###.###/####-##");
            element.TRS_INSC = mask(element.TRS_INSC, "###.###.###.###");
            element.TRS_CEP = mask(element.TRS_CEP, "#####-###");
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },

    postTransportadora() {
      api
        .post("/transportadora", this.removeMask(this.editedItem))
        .then(() => {
          alert("Transportadora cadastrada com sucesso");
          this.carregarTransportadora();
        })
        .catch(() => {
          alert("Erro ao cadastrar transportadora");
        });
    },

    updateTransportadora(id) {
      api
        .put(`/transportadora/${id}`, this.removeMask(this.editedItem))
        .then(() => {
          alert("Transportadora atualizada com sucesso");
          this.carregarTransportadora();
        })
        .catch(() => {
          alert("Erro ao cadastrar transportadora");
        });
    },

    deleteUser(id) {
      api
        .delete(`/transportadora/${id}`)
        .then(() => {
          alert("Transportadora deletada com sucesso");
          this.carregarTransportadora();
        })
        .catch(() => {
          alert("Erro ao deletar transportadora");
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
        this.updateTransportadora(this.editedItem.TRS_ID);
      } else {
        this.postTransportadora(this.editedIndex);
      }
      this.close();
    },
    removeMask(item) {
      item.TRS_CNPJ = item.TRS_CNPJ.replace(/[^0-9]/g, "");
      item.TRS_INSC = item.TRS_INSC.replace(/[^0-9]/g, "");
      item.TRS_CEP = item.TRS_CEP.replace(/[^0-9]/g, "");
      item.TRS_STATUS = "A";
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