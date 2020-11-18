var vthis = new Vue({
  el : "#app",
  data () {
    return {
      url : 'http://gestionboutique.local/api/v1/',
      tokenConfig : {
        'authorization' : '3bacb9ec-9fbc-4442-ab76-3a6e35b0a627',
        'Content-Type':'multipart/form-data'
      },
      tabListData: [],
      messageError : false,
      errorPopupClass : ['alert','alert-success'],
      errorPopupClassBottom : ['alert','alert-success'],
      messageErrorBottom : false,
      messageAlertConfig :{
        "title":"",
        "message":[],
      },
      messageAlertConfigBottom :{
        "title":"",
        "message":[],
      },
      dataToDisplay : [],
      styleModal : 'none',
      display : this.styleModal,
      modalTitle :"",

      // //DATA FILTRE
      // attente: 0,
      // payee: 0,
      // livree :0,
      // annuler:0,

      montantCaisse:0,

      //VARIABLE DETAIL SHOW AND ALL LOAD ACTION
      isShow : false,
      isNoQuantity : false,
      isLoadNego : false,
      isLoadNegoAnnuler : false,
      isLoadSaveMainButton : false,
      isLoadSaveMainButtonModal : false,
      isDecaissementExterne : false,



      //LIST PARTICULIERES
      depotList : [],
      caissierList :[],
      detailTab : [],
      ListFiltreData : [], //POUR MENU LISTE
      checkBoxArticles: [],
      ArticleValidateNego : {},


      //VARIABLE FORM ADD ARTICLE
      code_article :"",
      nom_article :"",
      poids :"",
      description  :"",
      users_id : localStorage.u,

      //VARIABLE FORM ADD ARTICLE PRIX ARTICLE
      articles_id:"",
      type_prix:"",
      qte_decideur:"",
      prix_unitaire:"",

      //VARIABLE ADD COMMANDES PETIT FORMULAIRE ARTICLES
      codeArticle :"",
      qte : 0,

      //VARIABLE CREATE COMMANDE
      numero_commande:"",
      nom_client:"",
      date_vente:"",
      payer_a : "",

      //VARIABLE FORM APPROVISIONNEMENT
      depots_id :"",
      date_approvisionnement :"",

      //VALIDATION PAYEMENT CAISSIER
      password_op : "",
      commande_id :"",
      somme_commande : "",

      //LISTE COMMANDE MAGAZ
      dpot_id : localStorage.dp,

      //VARIABLE LOGIQUE FILTRE SUR LISTE ATTENTE, PAYER, LIVRER ADMIN
      stateStatus :"",
      montantTotalAllCommandeParTypeVente : "",

      //VARIABLE DEMANDE DECAISSSEMENT
      caissier:"",
      montant_decaisse:"",
      note:"",

      //VARIABLE ACCEPTATION DECAISSEMENT CAISSIER PRINCIPAL
      decaissement_id :"",

      //VARIABLE DECAISSEMENT EXTERNE
      destination:"",
      montant:"",



    }
  },

  created () {
    this._u_fx_to_load_router();
    this._u_get_code_facture();
    this._u_get_today();
    this._u_fx_get_montant();
    // console.log(this.detailTab.logic_article);
  },
  methods : {
    add_article(e){
    e.preventDefault();
    const newurl = this.url+"articles-create-one";
    var form = this._u_fx_form_data_art();
    return axios
          .post(newurl,form,{headers: this.tokenConfig})
          .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this._u_fx_form_init_field();
                this.get_article();
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
          })
          .catch(error =>{
            console.log(error);
          })
  },
    get_article(){
      const newurl = this.url+"articles-get-all";
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              console.log(this.dataToDisplay);
            }).catch(error =>{
              console.log(error);
            })
    },
    add_article_prix(e){
      e.preventDefault();
      const newurl = this.url+"articles-create-price";
      var form = this._u_fx_form_data_art_price();
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this._u_fx_form_init_field();
                  this.get_article();
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
            })
            .catch(error =>{
              console.log(error);
            })
    },
    add_commande(e){
      e.preventDefault();
      const newurl = this.url+"/commandes-create";
      var form = new FormData();
      form.append('numero_commande',this.numero_commande);
      form.append('nom_client',this.nom_client);
      form.append('date_vente',this.date_vente);
      form.append('users_id',this.users_id);
      form.append('status_vente_id',1);
      form.append('depots_id',this.depots_id);
      form.append('payer_a',this.payer_a);

      for(var i=0; i< this.tabListData.length; i++){
        form.append('articles_id[]', this.tabListData[i]['id']);
        form.append('qte_vendue[]', this.tabListData[i]['qte']);
        form.append('prix_unitaire[]', this.tabListData[i]['prix_unit']);
				form.append('type_prix[]', this.tabListData[i]['type_id']);
			}
      if(this.tabListData.length < 1){
        this._u_fx_config_error_message("Erreur",["Veuillez renseigner les articles"],'alert-danger');
        return;
      }
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this._u_get_code_facture();
                  this.tabListData=[];
                  this.nom_client = "";
                  this.depots_id = "";
                  this.payer_a = "";
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
            })
            .catch(error =>{
              console.log(error);
            })
    },
    get_depots(){
      const newurl = this.url+"depot-get-all";
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.depotList = response.data.data;
              // console.log(this.depotList);
            }).catch(error =>{
              console.log(error);
            })
    },
    get_caissiers(){
      const newurl = this.url+"users-get-all/3/profile";
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.caissierList = response.data.data;
              console.log(this.caissierList);
            }).catch(error =>{
              console.log(error);
            })
    },
    add_approvision(e){
      e.preventDefault();
      const newurl = this.url+"approvisionnement-create";
      var form = new FormData();
      form.append('date_approvisionnement',this.date_approvisionnement);
      form.append('depots_id',this.depots_id);
      form.append('users_id',this.users_id);
        for(var i=0; i< this.tabListData.length; i++){
          console.log(this.tabListData[i].qtea);
          form.append('articles_id[]', this.tabListData[i].info[0].id);
          form.append('qte[]', this.tabListData[i].qtea);
  			}
        if(this.tabListData.length < 1){
          this._u_fx_config_error_message("Erreur",["Veuillez renseigner les articles"],'alert-danger');
          return;
        }
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  // this._u_fx_form_init_field();
                  // this.get_article();
                  this.tabListData=[];
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
            })
            .catch(error =>{
              console.log(error);
            })
    },
    get_commande_facturier(statut=1){
      const newurl = this.url+"commandes-get-all/"+this.users_id+"/"+statut+"/facturier";
      this.stateStatus = statut;
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.ListFiltreData = response.data.nombreVenteType;

            }).catch(error =>{
              console.log(error);
            })
    },
    get_commande_caissier(statut=1){
      const newurl = this.url+"commandes-get-all/"+this.users_id+"/"+statut+"/caissier";
      this.stateStatus = statut;
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.ListFiltreData = response.data.nombreVenteType;
              this._u_fx_get_montant();
            }).catch(error =>{
              console.log(error);
            })
    },
    add_validation_payement(){
      const newurl = this.url+"commandes-validation-caissier/"+this.password_op+"/"+this.commande_id+"/"+this.users_id+"/"+this.somme_commande+"/validation";
      if(this.password_op ==""){
        this._u_fx_config_error_message_bottom("Message",['Le mot de passe des opération est obligatoire'],'alert-danger');
        return;
      }
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_commande_caissier(2);
                this._u_close_mod_form();
                this.password_op= "";
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
            }).catch(error =>{
              console.log(error);
            })
    },
    get_commande_magazinier(statut=2){
      const newurl = this.url+"commandes-get-by-depot/"+this.dpot_id+"/"+statut+"/depot";
      this.stateStatus = statut;
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.ListFiltreData = response.data.nombreVenteType;
              console.log(this.dataToDisplay);
            }).catch(error =>{
              console.log(error);
            })
    },
    add_validation_livraison(){
      const newurl = this.url+"commandes-validation-magaz/"+this.password_op+"/"+this.commande_id+"/"+this.users_id+"/"+this.dpot_id+"/validation";
      if(this.password_op ==""){
        this._u_fx_config_error_message_bottom("Message",['Le mot de passe des opération est obligatoire'],'alert-danger');
        return;
      }
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_commande_magazinier(3);
                this._u_close_mod_form();
                this.password_op= "";
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
            }).catch(error =>{
              console.log(error);
            })
    },
    get_commande_admin(statut=1){
      const newurl = this.url+"commandes-all-by-status/"+statut+"/status";
      this.stateStatus = statut;
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.ListFiltreData = response.data.nombreVenteType;
              this.montantTotalAllCommandeParTypeVente = response.data.sommesTotalAllCommandes;
              // alert("HELLO");
              console.log(this.ListFiltreData);
            }).catch(error =>{
              console.log(error);
            })
    },
    add_ask_negotiation(cmd){
      this.isLoadNego = true;
      const newurl = this.url+"demande-negotiation";
      var form = new FormData();
      form.append('idcommande',cmd);
      for(var i=0; i< this.checkBoxArticles.length; i++){
        form.append('idarticle[]', this.checkBoxArticles[i]);
    	}
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadNego = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_commande_facturier(1);
                this._u_close_mod_form();
                this.checkBoxArticles = [];
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadNego = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    get_commande_attente_negotiation(statutNegotiation=1){
      const newurl = this.url+"achat-get-all-negotiation/"+statutNegotiation+"/negotiation";
      this.stateStatus = statutNegotiation;
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.ListFiltreData = response.data.nombreVenteTypeNegotiation;
              // console.log("====DATA=====");
              // console.log(this.dataToDisplay);
            }).catch(error =>{
              console.log(error);
            })
    },
    add_validate_negotiation(cmd){
      //console.log(Object.keys(this.ArticleValidateNego).length);
      this.isLoadNego = true;
      console.log(this.ArticleValidateNego);
      const newurl = this.url+"achat-validate-negotiation";
      var form = new FormData();
      form.append('idcommande',cmd);
      if(Object.keys(this.ArticleValidateNego).length < 1){
        this._u_fx_config_error_message_bottom("Message",['Veuillez prédefinir le montant de reduction'],'alert-danger');
        this.isLoadNego = false;
        return;
      }
      for(key in this.ArticleValidateNego){
          form.append('idarticle[]', this.ArticleValidateNego[key][0]);
          form.append('montant[]', this.ArticleValidateNego[key][1]);
    	}
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadNego = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_commande_attente_negotiation(2);
                // this._u_close_mod_form();
                this.ArticleValidateNego = [];
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadNego = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    add_annuler_tout_validate_negotiation(cmd){
      this.isLoadNegoAnnuler = true;
      const newurl = this.url+"achat-annuler-tout-negotiation";
      var form = new FormData();
      form.append('idcommande',cmd);
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadNegoAnnuler = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_commande_attente_negotiation(1);
                this.ArticleValidateNego = [];
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadNegoAnnuler = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    add_annuler_validate_negotiation_selectionneer(cmd){
      this.isLoadNegoAnnuler = true;
      const newurl = this.url+"achat-annuler-selection-negotiation";
      var form = new FormData();
      form.append('idcommande',cmd);
      for(var i=0; i< this.checkBoxArticles.length; i++){
        form.append('idarticle[]', this.checkBoxArticles[i]);
    	}
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadNegoAnnuler = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_commande_attente_negotiation(2);
                this.checkBoxArticles = [];
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadNegoAnnuler = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    get_caissier_main(){
      const newurl = this.url+"users-get-all-is-main-by-profile/3/1/is-main";
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.caissierList = response.data.data;
              // console.log(this.caissierList);
            }).catch(error =>{
              console.log(error);
            })
    },
    add_decaissement_demande(e){
    e.preventDefault();
    const newurl = this.url+"create-decaissement-solde";
    var form = this._u_fx_form_data_decaissement();
    this.isLoadSaveMainButton = true;
    return axios
          .post(newurl,form,{headers: this.tokenConfig})
          .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this._u_fx_form_init_field();
                this.get_decaisssement_caissier_secondaire();
                this.isLoadSaveMainButton = false;
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButton = false;
          })
          .catch(error =>{
            console.log(error);
          })
  },
    get_decaisssement_caissier_secondaire(){
    const newurl = this.url+"get-decaissement-par-caissier/"+this.users_id;
    return axios
          .get(newurl,{headers: this.tokenConfig})
          .then(response =>{
            this.dataToDisplay = response.data.data;
            console.log(this.dataToDisplay);
            // alert('here');
          }).catch(error =>{
            console.log(error);
          })
        },

    /*Fx POUR LISTE DE DEMANDES DE DECAISSEMENT COTE CAISSIER PRINCIPAL*/
    get_decaisssement_caissier_principale(status=2){
    const newurl = this.url+"get-all-decaissement/"+this.users_id+"/"+status+"/decaisse";
    return axios
          .get(newurl,{headers: this.tokenConfig})
          .then(response =>{
            this.isDecaissementExterne = false;
            this.dataToDisplay = response.data.data;

            // console.log(this.dataToDisplay);
            // alert('here');
          }).catch(error =>{
            console.log(error);
          })
        },

    /*Fx POUR VALIDATION DECAISSEMENT COTE CAISSIER PRINCIPAL*/
    add_validation_decaissement(){
      const newurl = this.url+"validation-decaissement/"+this.decaissement_id+"/"+this.users_id+"/"+this.password_op+"/validate";
      if(this.password_op ==""){
        this._u_fx_config_error_message_bottom("Message",['Le mot de passe des opération est obligatoire'],'alert-danger');
        return;
      }
      this.isLoadSaveMainButtonModal = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_decaisssement_caissier_principale();
                this._u_close_mod_form();
                this.password_op= "";
                this.isLoadSaveMainButtonModal = false;
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    add_decaissement_externe(e){
    e.preventDefault();
    const newurl = this.url+"create-decaissement--solde-externe";
    var form = this._u_fx_form_data_decaissement_externe();
    // console.log(this.montant);
    if(this.montant ==""){
      this._u_fx_config_error_message_bottom("Message",['Le montant est obligatoire'],'alert-danger');
      return;
    }
    this.isLoadSaveMainButton = true;
    return axios
          .post(newurl,form,{headers: this.tokenConfig})
          .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this._u_fx_form_init_field();
                this.get_decaisssement_externe();
                this._u_fx_get_montant();
                this.isLoadSaveMainButton = false;
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButton = false;
          })
          .catch(error =>{
            console.log(error);
          })
  },
    get_decaisssement_externe(){
      const newurl = this.url+"get-decaissement-externe-par-caissier/"+this.users_id;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.isDecaissementExterne = true;
              this.tabListData = response.data.data;
              console.log(this.tabListData);
            }).catch(error =>{
              console.log(error);
            })
    },


    _u_create_line_article(){
      const newurl = this.url+"articles-search-data-commande/"+this.codeArticle+"/"+this.qte+"/"+this.depots_id+"/search";
      if(this.depots_id ==""){
        this._u_fx_config_error_message_bottom("Message",['Veuillez selectionner un dépôt traiteur'],'alert-danger');
        return;
      }
      if(this.qte < 1){
        this._u_fx_config_error_message_bottom("Message",['La quantité doit être superieure à 1'],'alert-danger');
        return;
      }
      this.messageErrorBottom = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                this.tabListData.push(response.data.data);
                console.log(response.data.message.success);
                this._u_fx_config_error_message_bottom("Message",[response.data.message.success],'alert-success');
                this.codeArticle = "";
                this.qte = 0;
                return;
              }
              this._u_fx_config_error_message_bottom("Message",[response.data.message.errors],'alert-danger')

              // this._u_fx_field_multi_form_art();
            }).catch(error =>{
              console.log(error);
            })


    },
    _u_remove_line_list_art(index){
      this.tabListData.splice(index,1);
      this._u_fx_config_error_message_bottom("Message",['Bien supprimer'],'alert-info');
    },
    _u_create_line_article_appro(){
      const newurl = this.url+"articles-search-by-code/"+this.codeArticle+"/code";
      if(this.qte < 1){
        this._u_fx_config_error_message_bottom("Message",['La quantité doit être superieure à 1'],'alert-danger');
        return;
      }
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.data.length <1){
                this._u_fx_config_error_message_bottom("Message",['Le code article n\'existe pas'],'alert-danger');
                return;
              };
              this.tabListData.push({'info':response.data.data,'qtea':this.qte})
              console.log(this.tabListData[0].info[0].code_article);
              this.messageErrorBottom = false;
              this._u_fx_field_multi_form_art();
            }).catch(error =>{
              console.log(error);
            })
    },
    _u_open_mod_form(art,type){
      this._u_fx_form_init_field();
      this.type_prix = type;
      this.articles_id = art.id;
      type = type == 1 ?'Gros':'Détail';
      this.modalTitle = "Fixe le prix de l'article "+art.nom_article+" en "+type;
      this.styleModal = 'block';
    },
    _u_close_mod_form(){
      this.styleModal = 'none';
    },
    _u_open_mod_popup_caisse(cmd){
      //console.log("=====ARTICLE=====");
      //console.log(cmd);
      this.modalTitle = "VALIDATION DU PAYEMENT DE LA FACTURE"+cmd.numero_commande+" DU CLIENT "+cmd.nom_client;
      this.commande_id = cmd.id;
      this.somme_commande = cmd.logic_somme;
      this.styleModal = 'block';
    },
    _u_open_mod_popup_caissier_principal_validation_decaissement(dec){
      console.log("===DECAI===");
      console.log(dec);
      this.modalTitle = "VALIDATION DE LA RECEPTION DU MONTANT "+dec.montant+" USD DE LE(LA) CAISSIER(E) "+dec.users_id_from.nom+" "+dec.users_id_from.prenom;
      this.decaissement_id = dec.id;
      this.styleModal = 'block';
    },
    _u_open_mod_popup_magaz(cmd,val){
      if(val==3){
        this.isNoQuantity = true;
      }else{
        this.isNoQuantity = false;
      }
      this.modalTitle = "VALIDATION DE LA LIVRAISON DE LA FACTURE "+cmd.numero_commande+" DU CLIENT "+cmd.nom_client;
      this.commande_id = cmd.id;
      this.somme_commande = cmd.logic_somme;
      this.styleModal = 'block';
    },
    _u_get_today(){
      var currentDate = new Date();
      var currentDateWithFormat = new Date().toJSON().slice(0,10).replace(/-/g,'-');
      this.date_approvisionnement = currentDateWithFormat;
      this.date_vente = currentDateWithFormat;
    },
    _u_see_detail_tab(index){

      this.detailTab = index;
      this.isShow = !this.isShow;
      // console.log(this.detailTab.logic_article);
    },
    _u_get_code_facture(){
      const newurl = this.url+"commandes-generate-code";
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.numero_commande =response.data.data;
              // console.log(this.depotList);
            }).catch(error =>{
              console.log(error);
            })
    },
    _u_fx_create_tab_prod_validate_nego(idarticle, valueMontantInput){
      // console.log(valuInput);
        if(valueMontantInput !="" && valueMontantInput > 0){
          var arry = [idarticle,valueMontantInput];
          this.ArticleValidateNego[idarticle] = arry;
        }else{
          delete this.ArticleValidateNego[idarticle];
        }

    },
    _u_fx_get_montant(){
      const newurl = this.url+"caisse-montant/"+this.users_id;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.montantCaisse = response.data.data;

            }).catch(error =>{
              console.log(error);
            })
    },
    _u_fx_bodyClicked(){
      // this.messageError =false;
      // this.messageErrorBottom =false;
    },
    // FONCTIONS UTILITIES COMMUNES
    _u_fx_config_error_message(title, message, classError){
     this.errorPopupClass.splice(1,1);
     this.errorPopupClass.push(classError);
     this.messageAlertConfig.title = title;
     this.messageAlertConfig.message = [];
     this.messageAlertConfig.message.push(message);
     this.messageError = true;
     // console.log(this.messageAlertConfig);
   },
    _u_fx_config_error_message_bottom(title, message, classError){
    this.errorPopupClassBottom.splice(1,1);
    this.errorPopupClassBottom.push(classError);
    this.messageAlertConfigBottom.title = title;
    this.messageAlertConfigBottom.message = [];
    this.messageAlertConfigBottom.message.push(message);
    this.messageErrorBottom = true;
    console.log(this.messageAlertConfigBottom.message[0][0]);
  },
    _u_fx_form_init_field(){
      this.code_article = "";
      this.nom_article = "";
      this.poids = "";
      this.description = "";

      this.articles_id = "";
      this.type_prix = "";
      this.qte_decideur = "";
      this.prix_unitaire = "";

      //FORMULAIRE DEMANDE DECAISSEMENT
      this.caissier ="";
      this.montant_decaisse="";
      this.note ="";

      this.destination ="";
      this.montant ="";

    },
    _u_fx_form_data_art(){
     var formData = new FormData();
     formData.append('code_article',vthis.code_article);
     formData.append('nom_article',vthis.nom_article);
     formData.append('description',vthis.description);
     formData.append('poids',vthis.poids);
     formData.append('users_id',vthis.users_id);
     return formData;
   },
    _u_fx_form_data_art_price(){
      var formData = new FormData();
      formData.append('articles_id',vthis.articles_id);
      formData.append('type_prix',vthis.type_prix);
      formData.append('prix_unitaire',vthis.prix_unitaire);
      formData.append('qte_decideur',vthis.qte_decideur);
      formData.append('users_id',vthis.users_id);
      return formData;
    },
    _u_fx_field_multi_form_art(){
      this.codeArticle ="";
      this.qte = "";
    },
    _u_fx_form_data_decaissement(){
     var formData = new FormData();
     formData.append('users_id_from',vthis.users_id);
     formData.append('users_id_dest',vthis.caissier);
     formData.append('montant',vthis.montant_decaisse);
     formData.append('note',vthis.note);
     return formData;
   },
    _u_fx_form_data_decaissement_externe(){
    var formData = new FormData();
    formData.append('users_id_from',vthis.users_id);
    formData.append('destination',vthis.destination);
    formData.append('montant',vthis.montant);
    formData.append('note',vthis.note);
    return formData;
  },
    _u_fx_to_load_router(){
    const pth = window.location.pathname.split('/');
    if(pth[1] ==='admin-add-article' || pth[1] ==='admin-add-article'){
      this.get_article();
    }
    if(pth[1] ==='admin-add-appro' || pth[1] ==='facturier-add-achat' || pth[1]==='caissier-add-achat'){
      this.get_depots();
    }
    if(pth[1]=='facturier-add-achat' || pth[1]==='caissier-add-achat'){
      this.get_caissiers();
    }
    if(pth[1]=='facturier-list-achat'){
      this.get_commande_facturier();
    }
    if(pth[1]=='caissier-list-achat'){
      this.get_commande_caissier();
    }
    if(pth[1]=='magaz-list-achat'){
      this.get_commande_magazinier();
    }
    if(pth[1]=='admin-list-achat'){
      this.get_commande_admin();
    }
    if(pth[1]=='admin-list-negotiation-achat'){
      this.get_commande_attente_negotiation();
    }
    if(pth[1]=='caissier-add-decaissement'){
      this.get_caissier_main();
      this.get_decaisssement_caissier_secondaire();
    }
    if(pth[1]=='caissier-list-decaissement'){
      this.get_decaisssement_caissier_principale();
    }












  }

  }
})





// REFERENCES
/*
* CONVERT OBJECT IN ARRAYS
*/
// Object.keys(zoo);
// // ['lion', 'panda']
//
// Object.values(zoo);
// // ['🦁', '🐼']
//
// Object.entries(zoo);
// // [ ['lion', '🦁'], ['panda', '🐼'] ]
