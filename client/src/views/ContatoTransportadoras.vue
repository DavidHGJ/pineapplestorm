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
            >Contatos Transportadora
            <v-icon>mdi-account-circle</v-icon>
          </v-toolbar-title>
          <!-- <v-divider class="mx-4" inset vertical></v-divider> -->
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on }">
              <v-btn color="primary" dark class="mb-2 buttoncolor" v-on="on"
                >Novo Contato</v-btn
              >
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6" md="3">
                      <v-select
                        v-model="editedItem.TPC_ID"
                        :items="tiposContato"
                        item-text="name"
                        item-value="value"
                        label="Selecione o Tipo"
                        persistent-hint
                        return-object
                        @change="mudarTipo(editedItem.TPC_ID)"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="6" md="9">
                      <v-text-field
                        v-model="editedItem.CNT_DESC"
                        label="Descrição contato"
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
        <v-btn color="primary" @click="carregarContatos">Recarregar</v-btn>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
import api from "../api/api";

export default {
  name: "ContatoTransportadoras",
  data() {
    return {
      dialog: false,
      headers: [
        { text: "Id", value: "CNT_ID" },
        { text: "Tipo de Contato", value: "TPC_DESC" },
        { text: "Descrição", value: "CNT_DESC" },
        { text: "Ações", value: "action", sortable: false, align: "left" },
      ],
      desserts: [],
      tiposContato: [
        { name: "Telefone", value: "1" },
        { name: "Email", value: "2" },
      ],
      selectedItems: [],
      editedIndex: -1,
      editedItem: {
        TRS_ID: "",
        TPC_ID: "",
        CNT_DESC: "",
      },
      defaultItem: {
        TRS_ID: "",
        TPC_ID: "",
        CNT_DESC: "",
      },
      deleteCNT: {
        CNT_ID: "",
      },
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Novo Contato" : "Editar Contato";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
  },

  created() {
    this.carregarContatos();
  },
  methods: {
    carregarContatos() {
      api
        .get(`/transportadora-contato/${this.$route.params.id}`)
        .then((res) => {
          this.desserts = res.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    postContato() {
      api
        .post("/transportadora-contato", this.editedItem)
        .then(() => {
          alert("Contato adicionado com sucesso");
          this.carregarContatos();
        })
        .catch(() => {
          alert("Erro ao adicionar Contato");
        });
    },

    updateContato() {
      api
        .put(
          `/transportadora-contato/${this.$route.params.id}`,
          this.editedItem
        )
        .then(() => {
          alert("Categoria atualizada com sucesso");
          this.carregarContatos();
        })
        .catch(() => {
          alert("Erro ao cadastrar Categoria");
        });
    },

    deleteContato(id) {
      api
        .delete(`/transportadora-contato/${this.$route.params.id}`, {
          data: { CNT_ID: id },
        })
        .then(() => {
          alert("Contato deletado com sucesso");
          this.carregarContatos();
        })
        .catch(() => {
          alert("Erro ao deletar Contato");
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
      if (confirm("Tem certeza de que deseja excluir este Contato?")) {
        //this.desserts.splice(index, 1);
        this.deleteCNT.CNT_ID = idItem.CNT_ID;
        this.deleteContato(idItem.CNT_ID);
      }
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    validaCampos() {
      if (this.editedItem.CNT_DESC == "") return false;
      if (this.editedItem.TPC_ID == "") return false;
      this.editedItem.TRS_ID = this.$route.params.id;

      return true;
    },

    save() {
      if (this.validaCampos()) {
        if (this.editedIndex > -1) {
          this.updateContato();
        } else {
          this.postContato(this.editedIndex);
        }
        this.close();
      } else {
        alert("Favor preencher todos os campos");
      }
    },
    addStatus(item) {
      item.CAT_STATUS = "A";
      return item;
    },
    mudarTipo(item) {
      this.editedItem.TPC_ID = item.value;
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