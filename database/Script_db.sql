create database if not exists pine;

use pine;

/* Desabilita o case sensitive */
set @lower_case_table_names=2;

create table if not exists tipo_contato(
	tpc_id int auto_increment,
    tpc_desc varchar(45),
    
    constraint pk_tipo_contato primary key(tpc_id),
    constraint un_tipo_contato_desc unique key(tpc_desc)
);

create table if not exists contato(
	cnt_id int auto_increment,
    tpc_id int,
    cnt_desc varchar(255),
    
    constraint pk_contato primary key(cnt_id),
    constraint fk_cnt_tipo_contato foreign key(tpc_id) references tipo_contato(tpc_id),
    constraint un_contato_tpc_id_desc unique key(tpc_id, cnt_desc)
);

create table if not exists filiais(
	fil_id int auto_increment,
    fil_cnpj char(14),
    fil_insc char(12),
    fil_status char(1),
    fil_desc varchar(255),
    fil_cep char(9),
    fil_num int(9),
    fil_complemento varchar(45),
    
    constraint pk_filiais primary key(fil_id),
    constraint un_filiais_cnpj_insc unique key(fil_cnpj, fil_insc)
);

create table if not exists filiais_x_contato(
	fil_id int,
    cnt_id int,
    
    constraint fk_f_x_c_filiais foreign key(fil_id) references filiais(fil_id),
    constraint fk_f_x_c_contato foreign key(cnt_id) references contato(cnt_id),
    constraint un_filiaix_x_contato_fil_id_cnt_id unique key(fil_id, cnt_id)
);

create table if not exists transportadora(
	trs_id int auto_increment,
    trs_desc varchar(255),
    trs_num varchar(9),
    trs_cep char(9),
    trs_cnpj char(14),
    trs_insc char(12),
    trs_status char(1),
    trs_complemento varchar(45),
    
    constraint pk_transportadora primary key(trs_id),
    constraint un_transportadora_cnpj_insc unique key(trs_cnpj, trs_insc)
);

create table if not exists transportadora_x_contato(
	trs_id int,
    cnt_id int,
    
    constraint fk_trs_x_cnt_transportadora foreign key(trs_id) references transportadora(trs_id),
    constraint fk_trs_x_cnt_contato foreign key(cnt_id) references contato(cnt_id),
    constraint un_transportadora_x_contato_trs_id_cnt_id unique key(trs_id, cnt_id)
);

create table if not exists fornecedor(
	for_id int auto_increment,
    for_nome varchar(255),
    for_numero varchar(5),
    for_cep char(9),
    for_cnpj char(14),
    for_insc char(12),
    for_status char(1),
    for_complemento varchar(45),
    
    constraint pk_fornecedor primary key(for_id),
    constraint un_fornecedor_cnpj_insc unique key(for_cnpj, for_insc)
);

create table if not exists fornecedor_x_contato(
	for_id int,
    cnt_id int,
    
    constraint fk_for_x_cnt_fornecedor foreign key(for_id) references fornecedor(for_id),
    constraint fk_for_x_cnt_contato foreign key(cnt_id) references contato(cnt_id),
    constraint un_fornecedor_x_contato_for_id_cnt_id unique key(for_id, cnt_id)
);

create table if not exists categoria(
	cat_id int auto_increment,
    cat_desc varchar(255),
    cat_status char(1),
    
    constraint pk_categoria primary key(cat_id),
    constraint un_categoria_cat_desc unique key(cat_desc)
);

create table if not exists produto(
	prd_id int auto_increment,
    cat_id int,
    for_id int,
    prd_desc varchar(255),
    prd_peso double,
    prd_status char(1),
    prd_regdate datetime,
    
    constraint pk_produto primary key(prd_id),
    constraint fk_prd_categoria foreign key(cat_id) references categoria(cat_id),
    constraint fk_prd_fornecedor foreign key(for_id) references fornecedor(for_id),
    constraint un_produto_cat_id_for_id_prd_desc unique key(cat_id, for_id, prd_desc)
);

create table if not exists nota_fiscal(
	nf_id int auto_increment,
    nf_num varchar(9),
    nf_tipo int,
    nf_serie int(3),
    
    constraint pk_nota_fiscal primary key(nf_id),
    constraint un_nota_fiscal_num_tipo_seria unique key(nf_num, nf_tipo, nf_serie)
);

create table if not exists usuario(
	usr_id int auto_increment,
    usr_nome varchar(255),
    usr_login varchar(45),
    usr_senha varchar(255),
    usr_status char(1),
    usr_regdate datetime,
    usr_datanascimento datetime,
    
    constraint pk_usuario primary key(usr_id),
    constraint un_usuario_nome_login unique key(usr_nome, usr_login)
);

create table if not exists grupo(
	gru_id int,
    gru_nome varchar(255),
    gru_status char(1),
    
    constraint pk_grupo primary key(gru_id),
    constraint un_grupo_nome unique key(gru_nome)
);

create table if not exists grupo_x_usuario(
	gru_x_usr_id int,
    usr_id int,
    gru_id int,
    
    constraint pk_grupo_x_usuario primary key(gru_x_usr_id),
    constraint fk_g_x_u_usuario foreign key(usr_id) references usuario(usr_id),
    constraint fk_g_x_u_grupo foreign key(gru_id) references grupo(gru_id),
    constraint un_grupo_x_usuario_usr_id_gru_id unique key(usr_id, gru_id)
);

create table if not exists entrada(
	ent_id int auto_increment,
    trs_id int,
    ent_data date,
    ent_frete double,
    ent_imposto double,
    usr_id int,
    nf_id int,
    
    constraint pk_entrada primary key(ent_id),
    constraint fk_ent_transporte foreign key(trs_id) references transportadora(trs_id),
    constraint fk_ent_usuario foreign key(usr_id) references usuario(usr_id),
    constraint fk_ent_nota_fiscal foreign key(nf_id) references nota_fiscal(nf_id),
    constraint un_entrada_nf_id unique key(nf_id)
);

create table if not exists item_entrada(
	ite_id int auto_increment,
    prd_id int,
    ite_qtde double,
    ite_valor double,
    ent_id int,
    
    constraint pk_item_entrada primary key(ite_id),
    constraint fk_i_e_produto foreign key(prd_id) references produto(prd_id),
    constraint fk_i_e_entrada_id foreign key(ent_id) references entrada(ent_id),
    constraint un_item_entrada_prd_id_ent_id unique key(prd_id, ent_id)
);

create table if not exists saida(
	sai_id int auto_increment,
    fil_id int,
    sai_lote varchar(10),
    sai_data date,
    usr_id int,
    nf_id int,
    
    constraint pk_saida primary key(sai_id),
    constraint fk_s_filiais foreign key(fil_id) references filiais(fil_id),
    constraint fk_s_usuario foreign key(usr_id) references usuario(usr_id),
    constraint fk_s_nota_fiscal foreign key(nf_id) references nota_fiscal(nf_id),
    constraint un_saida_nf_id unique key(nf_id)
);

create table if not exists item_saida(
	its_id int auto_increment,
    prd_id int,
    sai_qtde double,
    sai_valor double,
    sai_id int,
    
    constraint pk_item_saida primary key(its_id),
    constraint fk_i_s_saida foreign key(sai_id) references saida(sai_id),
    constraint fk_i_s_produto foreign key(prd_id) references produto(prd_id),
    constraint fk_i_s_saida_id foreign key(sai_id) references saida(sai_id),
    constraint un_item_saida_prd_id_sai_id unique key(prd_id, sai_id)
);

-- SET GLOBAL log_bin_trust_function_creators = 1;

delimiter $$
create function calcula_quantidade_produto( 
	produto_id bigint 
) returns bigint
begin
	
	declare qtd_entrada bigint;    
    declare qtd_saida bigint;
    declare retorno bigint;
    
    set qtd_entrada = (select ifnull(sum(ite_qtde), 0) from item_entrada where prd_id = produto_id);
    set qtd_saida = (select ifnull(sum(sai_qtde), 0) from item_saida where prd_id = produto_id);
    
    set retorno = qtd_entrada - qtd_saida;
    
    return retorno;
end;
$$

delimiter $$ 
create function conta_qtde_items_saida(
	saida_id bigint
)returns bigint
begin
	declare retorno bigint;

	set retorno = (select ifnull(sum(sai_qtde), 0) from item_saida where sai_id = saida_id);
    
    return retorno;
end;
$$

delimiter $$ 
create function valor_total_items_saida(
	saida_id bigint
)returns bigint
begin
	declare retorno bigint;

	set retorno = (select ifnull(sum(sai_valor), 0) from item_saida where sai_id = saida_id);
    
    return retorno;
end
$$

delimiter $$ 
create function valor_total_items_entrada(
	entrada_id bigint
)returns bigint
begin
	declare retorno bigint;

	set retorno = (select ifnull(sum(ite_valor), 0) from item_entrada where ite_id = entrada_id);
    
    return retorno;
end;
$$

delimiter $$ 
create function conta_qtde_items_entrada(
	entrada_id bigint
)returns bigint
begin
	declare retorno bigint;

	set retorno = (select ifnull(sum(ite_qtde),0) from item_entrada where ite_id = entrada_id);
    
    return retorno;
end
$$




