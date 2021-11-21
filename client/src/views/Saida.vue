<template>
  <v-container class="pt-6">
    <v-row>
      <v-col lg="12" class="mb-10 ml-5 primary">
        <div class="alerts">
          <v-alert type="success" :value="alertSucess">
            Cadastrado com sucesso
          </v-alert>
          <v-alert type="error" :value="alertError">
            Erro ao cadastrar saída
          </v-alert>
        </div>
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
                  label="Lote"
                  v-maska="'##########'"
                  v-model="editedNF.SAI_LOTE"
                  :disabled="txt3"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="3" class="mt-4">
                <v-select
                  :items="filiaisCombo"
                  item-text="FIL_DESC"
                  item-value="FIL_ID"
                  return-object
                  v-model="editedNF.FILIAL"
                  label="Selecionar Filial"
                  outlined
                  dense
                  :disabled="txt4"
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
          :items="itensSaida"
          sort-by="calories"
          class="elevation-1 primary tabela"
        >
          <template v-slot:top>
            <v-toolbar flat color="primary">
              <v-toolbar-title
                >Itens de saída
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
      transportadoras: [],
      filiaisCombo: [],
      produtos: [],
      produtosCombo: [],
      itens: [],
      itensSaida: [],
      alertSucess: false,
      alertError: false,
      headers: [
        { text: "Produto", value: "PRD_DESC" },
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
        SAI_LOTE: "",
        TRS_ID: "",
        USR_ID: "",
        FILIAL: "",
        ITENS: [],
      },
      editedItem: {
        PRD_ID: "",
        ITE_QTDE: "",
        ITE_VALOR: "",
        ITE_LOTE: "",
        PRD_DESC: "",
        PROD: "",
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
    this.carregarFiliais();
    this.carregarProdutos();
  },
  methods: {
    carregarFiliais() {
      api
        .get("/filiais")
        .then((res) => {
          this.filiaisCombo = res.data.data;
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

    postSaida() {
      api
        .post("/entrada-nf", this.editedNF)
        .then(() => {
          alert("Saída adicionada com sucesso");
          this.$router.go(0);
        })
        .catch(() => {
          alert("Erro ao cadastrar Saída");
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
        this.editedItem.PRD_DESC = this.editedItem.PROD.PRD_DESC;
        this.itensSaida.push(this.editedItem);
      }
      this.close();
    },
    finalizar() {
      // if (confirm("Tem certeza de que deseja finalizar a saída?")) {
      //   if (this.editedNF.ITENS.length > 0) {
      //     this.itensSaida.forEach((element) => {
      //       element.PRD_ID = element.PROD.PRD_ID;
      //       this.editedNF.ITENS.push(element);
      //     });
      //   }
      //   this.postFornecedor();
      // }
    },
    addNota() {
      if (this.validaCampos()) {
        this.editedNF.NF_TIPO = "1";
        this.editedNF.USR_ID = "1";
        this.editedNF.FIL_ID = this.editedNF.FILIAL.FIL_ID;
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
      this.itensSaida = [];
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
      if (this.editedNF.SAI_LOTE == "") return false;
      if (this.editedNF.FILIAL == "") return false;
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
