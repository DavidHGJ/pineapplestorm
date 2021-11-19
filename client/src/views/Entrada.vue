<template>
  <v-container class="pt-6">
    <v-row>
      <v-col lg="12" class="mb-10 ml-5 primary">
        <h2 class="intro-text">Nova entrada</h2>
        <h3 class="intro-text">Adicionar Nota Fiscal</h3>

        <v-form>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="3">
                <v-text-field
                  label="Numero"
                  v-maska="'#########'"
                  v-model="editedNF.NF_NUM"
                  :disabled="txt1"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="2">
                <v-text-field
                  label="Série"
                  v-maska="'###'"
                  v-model="editedNF.NF_SERIE"
                  :disabled="txt2"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="2">
                <v-text-field
                  label="Valor Frete"
                  v-maska="'##########'"
                  v-model="editedNF.ENT_FRETE"
                  :disabled="txt3"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="2">
                <v-text-field
                  label="Valor Imposto"
                  v-maska="'##########'"
                  v-model="editedNF.ENT_IMPOSTO"
                  :disabled="txt4"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="3" class="mt-4">
                <v-combobox
                  :items="transportadorasCombo"
                  v-model="editedNF.TRS_DESC"
                  label="Selecionar Transportadora"
                  outlined
                  dense
                  :disabled="txt5"
                ></v-combobox>
              </v-col>
            </v-row>

            <v-btn
              color="buttoncolor"
              class="mr-4"
              @click="addNota"
              :disabled="btn1"
            >
              Adicionar nota
            </v-btn>
          </v-container>
        </v-form>
      </v-col>
      <v-col lg="12" class="mb-10 ml-5 primary" v-show="enableItens">
        <v-data-table
          :headers="headers"
          :items="itensEntrada"
          sort-by="calories"
          class="elevation-1 primary tabela"
        >
          <template v-slot:top>
            <v-toolbar flat color="primary">
              <v-toolbar-title
                >Itens de entrada
                <v-icon>mdi-truck</v-icon>
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
                        <v-col cols="12" sm="6" md="8" class="mt-4">
                          <v-combobox
                            :items="produtosCombo"
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
        <v-btn color="error" class="mr-4 mt-4" @click="enableFields()">
          Voltar
        </v-btn>
        <v-btn color="buttoncolor" class="mr-4 mt-4" @click="finalizar">
          Finalizar entrada
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import api from "../api/api";

export default {
  name: "Entrada",
  data() {
    return {
      transportadoras: [],
      transportadorasCombo: [],
      produtos: [],
      produtosCombo: [],
      itens: [],
      itensEntrada: [],
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
        USR_ID: "",
        ITENS: [],
      },
      editedItem: {
        PRD_ID: "",
        ITE_QTDE: "",
        ITE_VALOR: "",
        ITE_LOTE: "",
      },
      defaultItem: {
        PRD_ID: "",
        ITE_QTDE: "",
        ITE_VALOR: "",
        ITE_LOTE: "",
      },
      enableItens: false,
      txt1: false,
      txt2: false,
      txt3: false,
      txt4: false,
      txt5: false,
      btn1: false,
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
    this.carregarTransportadora();
    this.carregarProdutos();
  },
  methods: {
    carregarTransportadora() {
      api
        .get("/transportadora")
        .then((res) => {
          this.transportadoras = res.data.data;
          res.data.data.forEach((element) => {
            this.transportadorasCombo.push(element.TRS_DESC);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    carregarProdutos() {
      api
        .get("/produtos")
        .then((res) => {
          this.produtos = res.data.data;
          res.data.data.forEach((element) => {
            this.produtosCombo.push(element.PRD_DESC);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    editItem(item) {
      this.editedIndex = this.itensEntrada.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.itensEntrada.indexOf(item);
      confirm("Tem certeza de que deseja excluir este item?") &&
        this.itensEntrada.splice(index, 1);
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
        Object.assign(this.itensEntrada[this.editedIndex], this.editedItem);
      } else {
        this.itensEntrada.push(this.editedItem);
      }
      this.close();
    },
    finalizar() {
      this.itensEntrada.forEach((element) => {
        element.PRD_ID = this.produtos.find(
          (e) => e.PRD_DESC === element.PRD_ID
        ).PRD_ID;
        this.editedNF.ITENS.push(element);
      });

      console.log(JSON.stringify(this.editedNF));
    },
    addNota() {
      this.editedNF.NF_TIPO = "0";
      this.editedNF.USR_ID = "1";
      this.editedNF.TRS_ID = this.transportadoras.find(
        (element) => element.TRS_DESC === this.editedNF.TRS_DESC
      ).TRS_ID;
      this.enableItens = true;
      this.disableFields();
    },
    disableFields() {
      this.txt1 = true;
      this.txt2 = true;
      this.txt3 = true;
      this.txt4 = true;
      this.txt5 = true;
      this.btn1 = true;
    },

    enableFields() {
      this.txt1 = false;
      this.txt2 = false;
      this.txt3 = false;
      this.txt4 = false;
      this.txt5 = false;
      this.btn1 = false;
      this.enableItens = false;
      this.itensEntrada = [];
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