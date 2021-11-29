<template>
  <v-container class="pt-6">
    <v-row>
      <v-col lg="12" class="mb-10 ml-5 primary">
        <div class="alerts">
          <v-alert type="success" :value="alertSucess">
            Cadastrado com sucesso
          </v-alert>
          <v-alert type="error" :value="alertError">
            Erro ao cadastrar entrada
          </v-alert>
        </div>
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
                  label="Valor Frete (R$)"
                  v-maska="'##########'"
                  v-model="editedNF.ENT_FRETE"
                  :disabled="txt3"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="2">
                <v-text-field
                  label="Valor Imposto (R$)"
                  v-maska="'##########'"
                  v-model="editedNF.ENT_IMPOSTO"
                  :disabled="txt4"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="3" class="mt-4">
                <v-select
                  :items="transportadorasCombo"
                  item-text="TRS_DESC"
                  item-value="TRS_ID"
                  return-object
                  v-model="editedNF.TRANSP"
                  label="Selecionar Transportadora"
                  outlined
                  dense
                  :disabled="txt5"
                ></v-select>
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
          hide-default-footer
          disable-pagination
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
                          <v-select
                            :items="produtosCombo"
                            item-text="PRD_DESC"
                            item-value="PRD_ID"
                            return-object
                            v-model="editedItem.PROD"
                            label="Produto"
                            outlined
                            dense
                          ></v-select>
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
                            label="Valor (R$)"
                            v-maska="'##########'"
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
    <v-data-table
      hide-default-footer
      disable-pagination
      :headers="headersEntrada"
      :items="dessertsEntrada"
      class="elevation-1 primary tabela"
    >
      <template v-slot:top>
        <v-toolbar flat color="primary">
          <v-toolbar-title
            >Lista de entradas
            <v-icon>mdi-truck</v-icon>
          </v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="carregarFornecedor">Recarregar</v-btn>
      </template>
    </v-data-table>
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
      alertSucess: false,
      alertError: false,
      headers: [
        { text: "Produto", value: "PRD_DESC" },
        { text: "Quantidade", value: "ITE_QTDE" },
        { text: "Valor", value: "ITE_VALOR" },
        { text: "Ações", value: "action", sortable: false, align: "left" },
      ],
      headersEntrada: [
        { text: "Id", value: "ENT_ID" },
        { text: "Transportadora", value: "TRS_ID" },
        { text: "Data", value: "ENT_DATA" },
        { text: "Qtde", value: "ENT_QTDE" },
        { text: "Valor (R$)", value: "ENT_VALOR" },
        { text: "Frete (R$)", value: "ENT_FRETE" },
        { text: "Imposto (R$)", value: "ENT_IMPOSTO" },
      ],
      dessertsEntrada: [],
      dialog: false,
      editedIndex: -1,
      editedNF: {
        NF_NUM: "",
        NF_SERIE: "",
        NF_TIPO: "",
        TRS_ID: "",
        USR_ID: "",
        TRANSP: "",
        ITENS: [],
      },
      editedItem: {
        PRD_ID: "",
        PRD_DESC: "",
        ITE_QTDE: "",
        ITE_VALOR: "",
      },
      defaultItem: {
        PRD_ID: "",
        PRD_DESC: "",
        ITE_QTDE: "",
        ITE_VALOR: "",
      },
      enableItens: false,
      txt1: false,
      txt2: false,
      txt3: false,
      txt4: false,
      txt5: false,
      btn1: false,
      valid: true,
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
    this.carregarEntradas();
  },
  methods: {
    carregarTransportadora() {
      api
        .get("/transportadora")
        .then((res) => {
          this.transportadorasCombo = res.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    carregarProdutos() {
      api
        .get("/produtos")
        .then((res) => {
          this.produtosCombo = res.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    carregarEntradas() {
      api
        .get("/entrada-nf")
        .then((res) => {
          this.dessertsEntrada = res.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    postEntrada() {
      api
        .post("/entrada-nf", this.editedNF)
        .then(() => {
          alert("Entrada adicionada com sucesso");
          this.$router.go(0);
        })
        .catch(() => {
          alert("Erro ao cadastrar Entrada");
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
        this.editedItem.PRD_ID = this.editedItem.PROD.PRD_ID;
        this.editedItem.PRD_DESC = this.editedItem.PROD.PRD_DESC;
        this.itensEntrada.push(this.editedItem);
        console.log(this.itensEntrada);
      }
      this.close();
    },
    finalizar() {
      if (confirm("Tem certeza de que deseja finalizar a entrada?")) {
        if (this.itensEntrada.length > 0) {
          this.itensEntrada.forEach((element) => {
            this.editedNF.ITENS.push(element);
          });
          this.postEntrada();
        } else {
          alert("Favor adicionar pelo menos 1 item ao produtos");
        }
      }
    },
    addNota() {
      if (this.validaCampos()) {
        this.editedNF.NF_TIPO = "0";
        this.editedNF.USR_ID = "1";
        this.editedNF.TRS_ID = this.editedNF.TRANSP.TRS_ID;
        console.log(this.editedNF);
        this.enableItens = true;
        this.disableFields();
      } else {
        alert("Favor preencher todos os campos!!");
      }
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

    showSucessMsg() {
      this.alertSucess = true;
      setTimeout(() => {
        this.alertSucess = false;
      }, 5000);
    },
    showErrorMsg() {
      this.alertError = true;
      setTimeout(() => {
        this.alertError = false;
      }, 5000);
    },
    validaCampos() {
      if (this.editedNF.NF_NUM == "") return false;
      if (this.editedNF.NF_SERIE == "") return false;
      if (this.editedNF.ENT_FRETE == "") return false;
      if (this.editedNF.ENT_IMPOSTO == "") return false;
      if (this.editedNF.ENT_IMPOSTO == "") return false;
      if (this.editedNF.TRANSP == "") return false;
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
.buttoncolor {
  background-color: "#ffb500";
}
.alerts {
  width: 200px;
  height: 100px;
  position: relative;
  float: right;
}
</style>
