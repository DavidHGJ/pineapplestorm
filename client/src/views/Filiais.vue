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
            >Filiais
            <v-icon>mdi-home-outline</v-icon>
          </v-toolbar-title>
          <!-- <v-divider class="mx-4" inset vertical></v-divider> -->
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on }">
              <v-btn color="primary" dark class="mb-2 buttoncolor" v-on="on"
                >Nova Filial</v-btn
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
                        v-model="editedItem.FIL_DESC"
                        label="Nome da Filial"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="editedItem.FIL_CNPJ"
                        label="CNPJ"
                        v-maska="'##.###.###/####-##'"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.FIL_INSC"
                        label="INSC"
                        v-maska="'###.###.###.###'"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.FIL_CEP"
                        label="CEP"
                        v-maska="'#####-###'"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.FIL_NUM"
                        label="NUMERO"
                        v-maska="'#########'"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="8">
                      <v-text-field
                        v-model="editedItem.FIL_COMPLEMENTO"
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
        <v-btn color="primary" @click="carregarFilial">Resetar</v-btn>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
import api from "../api/api";
import { mask } from "maska";
import { cnpjValidation } from "../../js/cnpj.validation";

export default {
  name: "Filiais",
  data() {
    return {
      dialog: false,
      headers: [
        { text: "id", value: "FIL_ID" },
        { text: "Descrição", value: "FIL_DESC" },
        { text: "CNPJ", value: "FIL_CNPJ" },
        { text: "INSC", value: "FIL_INSC" },
        { text: "Cep", value: "FIL_CEP" },
        { text: "Numero", value: "FIL_NUM" },
        { text: "Complemento", value: "FIL_COMPLEMENTO" },
        { text: "Ações", value: "action", sortable: false, align: "left" },
      ],
      desserts: [],
      editedIndex: -1,
      editedItem: {
        FIL_DESC: "",
        FIL_NUM: "",
        FIL_CEP: "",
        FIL_CNPJ: "",
        FIL_INSC: "",
        FIL_STATUS: "",
        FIL_COMPLEMENTO: "",
      },
      defaultItem: {
        FIL_DESC: "",
        FIL_NUM: "",
        FIL_CEP: "",
        FIL_CNPJ: "",
        FIL_INSC: "",
        FIL_STATUS: "",
        FIL_COMPLEMENTO: "",
      },
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nova Filial" : "Editar Filial";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
  },

  created() {
    this.carregarFilial();
  },
  methods: {
    carregarFilial() {
      api
        .get("/filiais")
        .then((res) => {
          this.desserts = res.data.data;
          this.desserts.forEach((element) => {
            element.FIL_CNPJ = mask(element.FIL_CNPJ, "##.###.###/####-##");
            element.FIL_INSC = mask(element.FIL_INSC, "###.###.###.###");
            element.FIL_CEP = mask(element.FIL_CEP, "#####-###");
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },

    postFilial() {
      api
        .post("/filiais", this.removeMask(this.editedItem))
        .then(() => {
          alert("Filial cadastrada com sucesso");
          this.carregarFilial();
        })
        .catch(() => {
          alert("Erro ao cadastrar Filial");
        });
    },

    updateFilial(id) {
      api
        .put(`/filiais/${id}`, this.removeMask(this.editedItem))
        .then(() => {
          alert("Filial atualizada com sucesso");
          this.carregarFilial();
        })
        .catch(() => {
          alert("Erro ao cadastrar Filial");
        });
    },

    deleteUser(id) {
      api
        .delete(`/filiais/${id}`)
        .then(() => {
          alert("Filial deletada com sucesso");
          this.carregarFilial();
        })
        .catch(() => {
          alert("Erro ao deletar Filial");
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
        this.deleteUser(idItem.FIL_ID);
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    save() {
      if (this.validaCnpj(this.editedItem.FIL_CNPJ)) {
        if (this.editedIndex > -1) {
          this.updateFilial(this.editedItem.FIL_ID);
        } else {
          this.postFilial(this.editedIndex);
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
      item.FIL_CNPJ = item.FIL_CNPJ.replace(/[^0-9]/g, "");
      item.FIL_INSC = item.FIL_INSC.replace(/[^0-9]/g, "");
      item.FIL_CEP = item.FIL_CEP.replace(/[^0-9]/g, "");
      item.FIL_STATUS = "A";
      return item;
    },
    abrirContatos(item) {
      this.$router.push({ path: `/ContatoFiliais/${item.FIL_ID}` }); // -> /user/123
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