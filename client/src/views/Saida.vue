<template>
  <v-container class="pt-6">
    <v-row>
      <v-col lg="12" class="mb-10 ml-5 primary">
        <h2 class="intro-text">Nova saída</h2>
        <h3 class="intro-text">Adicionar Nota Fiscal</h3>

        <v-form>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="3">
                <v-text-field
                  label="Numero"
                  v-maska="'#########'"
                  v-model="editedNF.NF_NUM"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="2">
                <v-text-field
                  label="Série"
                  v-maska="'###'"
                  v-model="editedNF.NF_SERIE"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="2">
                <v-text-field
                  label="Lote"
                  v-maska="'##########'"
                  v-model="editedNF.SAI_LOTE"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="3" class="mt-4">
                <v-combobox
                  :items="filiaisCombo"
                  v-model="editedNF.TRS_DESC"
                  label="Selecionar Filial"
                  outlined
                  dense
                ></v-combobox>
              </v-col>
            </v-row>

            <v-btn color="buttoncolor" class="mr-4" @click="addNota">
              Adicionar nota
            </v-btn>
          </v-container>
        </v-form>
      </v-col>
      <v-col lg="12" class="mb-10 ml-5 primary">
        <v-data-table
          :headers="headers"
          :items="itensSaida"
          sort-by="calories"
          class="elevation-1 primary tabela"
        >
          <template v-slot:top>
            <v-toolbar flat color="primary">
              <v-toolbar-title
                >Itens de saída
                <v-icon>mdi-truck-delivery</v-icon>
              </v-toolbar-title>
              <!-- <v-divider class="mx-4" inset vertical></v-divider> -->
              <v-spacer></v-spacer>
              <v-dialog v-model="dialog" max-width="500px">
                <template v-slot:activator="{ on }">
                  <v-btn color="primary" dark class="mb-2 buttoncolor" v-on="on"
                    >Novo Item</v-btn
                  >
                </template>
                <v-card>
                  <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                  </v-card-title>

                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col cols="12" sm="6" md="4" class="mt-4">
                          <v-combobox
                            :items="produtos"
                            v-model="editedItem.PRD_ID"
                            label="Produto"
                            outlined
                            dense
                          ></v-combobox>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field
                            v-model="editedItem.ITE_QTDE"
                            label="Quantidade"
                            v-maska="'###########'"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field
                            v-model="editedItem.ITE_VALOR"
                            label="Valor"
                            v-maska="'##########'"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field
                            v-model="editedItem.ITE_LOTE"
                            label="Lote"
                            v-maska="'#########'"
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
                    <v-btn color="blue darken-1" text @click="save"
                      >Salvar</v-btn
                    >
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-toolbar>
          </template>
          <template v-slot:[`item.action`]="{ item }">
            <v-icon small class="mr-2" @click="editItem(item)"> Editar </v-icon>
            <v-icon small @click="deleteItem(item)"> Deletar </v-icon>
          </template>
        </v-data-table>
        <v-btn color="buttoncolor" class="mr-4 mt-4" @click="finalizar">
          Finalizar saída
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import api from "../api/api";

export default {
  name: "Saida",
  data() {
    return {
      select: ["Vuetify", "Programming"],
      filiais: [],
      filiaisCombo: [],
      produtos: [],
      itensSaida: [],
      headers: [
        { text: "Produto", value: "PRD_ID" },
        { text: "Quantidade", value: "ITE_QTDE" },
        { text: "Valor", value: "ITE_VALOR" },
        { text: "Lote", value: "ITE_LOTE" },
        { text: "Ações", value: "action", sortable: false, align: "left" },
      ],
      dialog: false,
      editedIndex: -1,
      editedNF: {
        NF_NUM: "",
        NF_SERIE: "",
        NF_TIPO: "",
        TRS_ID: "",
        TRS_DESC: "",
        USR_ID: "",
        ITENS: [],
      },
      editedItem: {
        ITE_ID: "",
        PRD_ID: "",
        ITE_QTDE: "",
        ITE_VALOR: "",
        ITE_LOTE: "",
      },
      defaultItem: {
        ITE_ID: "",
        PRD_ID: "",
        ITE_QTDE: "",
        ITE_VALOR: "",
        ITE_LOTE: "",
      },
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Novo Item" : "Editar Item";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
  },
  created() {
    this.carregarFiliais();
    this.carregarProdutos();
  },
  methods: {
    carregarFiliais() {
      api
        .get("/filiais")
        .then((res) => {
          this.filiais = res.data.data;
          res.data.data.forEach((element) => {
            this.filiaisCombo.push(element.FIL_DESC);
          });
        })
        .catch((error) => {
          console.log(error);
          alert("DEU ERRO");
        });
    },
    carregarProdutos() {
      api
        .get("/produtos")
        .then((res) => {
          res.data.data.forEach((element) => {
            this.produtos.push(element.PRD_DESC);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    editItem(item) {
      this.editedIndex = this.itensSaida.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.itensSaida.indexOf(item);
      confirm("Tem certeza de que deseja excluir este item?") &&
        this.itensSaida.splice(index, 1);
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
        Object.assign(this.itensSaida[this.editedIndex], this.editedItem);
      } else {
        this.itensSaida.push(this.editedItem);
      }
      this.close();
    },
    finalizar() {
      this.editedNF.ITENS.push(this.itensSaida);
      console.log(JSON.stringify(this.editedNF));
    },
    addNota() {
      this.editedNF.NF_TIPO = "0";
      this.editedNF.USR_ID = "1";

      console.log(this.editedNF);

      this.editedNF.FIL_ID = this.filiais.find(
        (element) => element.FIL_DESC === this.editedNF.FIL_DESC
      );
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
.buttoncolor {
  background-color: "#ffb500";
}
</style>