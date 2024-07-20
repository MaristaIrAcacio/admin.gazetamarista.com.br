<?php
/* Smarty version 3.1.36, created on 2024-07-19 21:10:00
  from 'c:\xampp-7.4\htdocs\rkadvisors.com.br\application\modules\default\views\index\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_669b0058471de3_90921216',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e528e51df0eecba13e3a29ea4801f96709b98261' => 
    array (
      0 => 'c:\\xampp-7.4\\htdocs\\rkadvisors.com.br\\application\\modules\\default\\views\\index\\index.tpl',
      1 => 1721433221,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669b0058471de3_90921216 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp-7.4\\htdocs\\rkadvisors.com.br\\library\\gazetamarista\\Library\\Smarty\\plugins\\modifier.replace.php','function'=>'smarty_modifier_replace',),1=>array('file'=>'C:\\xampp-7.4\\htdocs\\rkadvisors.com.br\\library\\gazetamarista\\Library\\Smarty\\plugins\\modifier.truncate.php','function'=>'smarty_modifier_truncate',),));
?>
<main id="site-corpo" class="main-index">
	<section class="slides tipo-slideshow banners"
		data-slide='{"autoplay":{"delay":5000}, "loop":true, "effect":"fade", "fadeEffect":{"crossFade": false}}'
		>

		<?php if (!empty($_smarty_tpl->tpl_vars['configuracao']->value->whatsapp)) {?>
			<div class="whatsapp-float uk-visible@m">
				<a
					href="https://wa.me/<?php echo smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['configuracao']->value->whatsapp,'+',''),'(',''),')',''),'-',''),' ','');?>
">
					<i class="icon-whatsapp-b"></i>
				</a>
			</div>
		<?php }?>

		<div class="swiper-container">
			<?php if (count($_smarty_tpl->tpl_vars['banners']->value) > 1) {?>
				<div class="swiper-button-prev uk-hidden@m mobile-arrow">
					<i class="icon-arrow-left"></i>
				</div>
			<?php }?>
			<div class="swiper-wrapper">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['banners']->value, 'banner');
$_smarty_tpl->tpl_vars['banner']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['banner']->value) {
$_smarty_tpl->tpl_vars['banner']->do_else = false;
?>
					<?php $_smarty_tpl->_assignInScope('banner_existe', ("common/uploads/banner/").($_smarty_tpl->tpl_vars['banner']->value->imagem_desktop));?>
					<?php if (file_exists($_smarty_tpl->tpl_vars['banner_existe']->value)) {?>
						<?php if (!empty($_smarty_tpl->tpl_vars['banner']->value->imagem_desktop)) {?>
							<?php $_smarty_tpl->_assignInScope('bg_desktop', $_smarty_tpl->tpl_vars['this']->value->url(array('tipo'=>'banner','crop'=>'1','largura'=>1920,'altura'=>1080,'imagem'=>$_smarty_tpl->tpl_vars['banner']->value->imagem_desktop),'imagem',TRUE));?>
						<?php } else { ?>
							<?php $_smarty_tpl->_assignInScope('bg_desktop', $_smarty_tpl->tpl_vars['this']->value->url(array('tipo'=>'banner','crop'=>'1','largura'=>1920,'altura'=>1080,'imagem'=>"imagempadrao.png"),'imagem',TRUE));?>
						<?php }?>

						<?php $_smarty_tpl->_assignInScope('banner_existe', ("common/uploads/banner/").($_smarty_tpl->tpl_vars['banner']->value->imagem_mobile));?>
						<?php if (file_exists($_smarty_tpl->tpl_vars['banner_existe']->value) && !empty($_smarty_tpl->tpl_vars['banner']->value->imagem_mobile)) {?>
							<?php $_smarty_tpl->_assignInScope('bg_mobile', $_smarty_tpl->tpl_vars['this']->value->url(array('tipo'=>'banner','crop'=>'1','largura'=>400,'altura'=>660,'imagem'=>$_smarty_tpl->tpl_vars['banner']->value->imagem_mobile),'imagem',TRUE));?>
						<?php } else { ?>
							<?php if (!empty($_smarty_tpl->tpl_vars['banner']->value->imagem_desktop)) {?>
								<?php $_smarty_tpl->_assignInScope('bg_mobile', $_smarty_tpl->tpl_vars['this']->value->url(array('tipo'=>'banner','crop'=>'1','largura'=>400,'altura'=>660,'imagem'=>$_smarty_tpl->tpl_vars['banner']->value->imagem_desktop),'imagem',TRUE));?>
							<?php } else { ?>
								<?php $_smarty_tpl->_assignInScope('bg_mobile', $_smarty_tpl->tpl_vars['this']->value->url(array('tipo'=>'banner','crop'=>'1','largura'=>400,'altura'=>660,'imagem'=>"imagempadrao.png"),'imagem',TRUE));?>
							<?php }?>
						<?php }?>

						<?php if (!empty($_smarty_tpl->tpl_vars['banner']->value->link)) {?>
							<?php $_smarty_tpl->_assignInScope('linkurl', tratar_link_externo($_smarty_tpl->tpl_vars['banner']->value->link));?>
						<?php } else { ?>
							<?php $_smarty_tpl->_assignInScope('linkurl', '');?>
						<?php }?>

						<div class="swiper-slide">
							<div class="slide-title">
								<div class="content">
									<h2><?php echo $_smarty_tpl->tpl_vars['banner']->value->titulo;?>
</h2>
								</div>
								<?php if (!empty($_smarty_tpl->tpl_vars['linkurl']->value) || !empty($_smarty_tpl->tpl_vars['configuracao']->value->whatsapp)) {?>
									<div class="slide-buttons">
										<?php if (!empty($_smarty_tpl->tpl_vars['linkurl']->value)) {?>
											<a class="button-container" href="<?php echo $_smarty_tpl->tpl_vars['linkurl']->value;?>
">
												<button
													class="uk-button uk-button-primary"><?php if (!empty($_smarty_tpl->tpl_vars['banner']->value->botao_txt)) {
echo $_smarty_tpl->tpl_vars['banner']->value->botao_txt;?>

													<?php } else { ?>Ver
													mais detalhes<?php }?></button>
											</a>
										<?php }?>
										<?php if (!empty($_smarty_tpl->tpl_vars['configuracao']->value->whatsapp)) {?>
											<a class="whatsapp-button uk-hidden@m"
												href="https://wa.me/<?php echo smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['configuracao']->value->whatsapp,'+',''),'(',''),')',''),'-',''),' ','');?>
">
												<img src="common/default/images/icons/icon-whatsapp.svg" alt=""> Chamar no whatsapp
											</a>
										<?php }?>
									</div>
								<?php }?>
							</div>
							<img class="uk-visible@s" data-src="<?php echo $_smarty_tpl->tpl_vars['bg_desktop']->value;?>
" data-width="1920" data-height="1080" uk-img
								alt="<?php echo $_smarty_tpl->tpl_vars['banner']->value->titulo;?>
">
							<img class="uk-hidden@s" data-src="<?php echo $_smarty_tpl->tpl_vars['bg_mobile']->value;?>
" data-width="400" data-height="658" uk-img
								alt="<?php echo $_smarty_tpl->tpl_vars['banner']->value->titulo;?>
">
						</div>
					<?php }?>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			</div>
			<?php if (count($_smarty_tpl->tpl_vars['banners']->value) > 1) {?>
				<div class="swiper-button-next uk-hidden@m mobile-arrow">
					<i class="icon-arrow-right"></i>
				</div>
			<?php }?>
			<div class="swiper-pagination uk-visible@m"></div>
			<?php if (count($_smarty_tpl->tpl_vars['banners']->value) > 1) {?>
				<div class="swiper-button-prev uk-visible@m">Anterior</div>
				<div class="swiper-button-next uk-visible@m">Próximo</div>
			<?php }?>
		</div>
	</section>

	<?php if (!empty($_smarty_tpl->tpl_vars['sobre']->value->descricao1) || !empty($_smarty_tpl->tpl_vars['sobre']->value->link_video) || !empty($_smarty_tpl->tpl_vars['sobre']->value->descricao2)) {?>
		<?php $_smarty_tpl->_assignInScope('bg_existe', ("common/uploads/sobre/").($_smarty_tpl->tpl_vars['sobre']->value->thumb_desktop));?>
		<?php if (file_exists($_smarty_tpl->tpl_vars['bg_existe']->value) && !empty($_smarty_tpl->tpl_vars['sobre']->value->thumb_desktop)) {?>
			<?php $_smarty_tpl->_assignInScope('thumb_desktop', $_smarty_tpl->tpl_vars['this']->value->url(array('tipo'=>'sobre','crop'=>1,'largura'=>1920,'altura'=>1080,'imagem'=>$_smarty_tpl->tpl_vars['sobre']->value->thumb_desktop),'imagem',TRUE));?>
		<?php }?>
		<?php if (file_exists($_smarty_tpl->tpl_vars['bg_existe']->value) && !empty($_smarty_tpl->tpl_vars['sobre']->value->thumb_mobile)) {?>
			<?php $_smarty_tpl->_assignInScope('thumb_mobile', $_smarty_tpl->tpl_vars['this']->value->url(array('tipo'=>'sobre','crop'=>1,'largura'=>400,'altura'=>660,'imagem'=>$_smarty_tpl->tpl_vars['sobre']->value->thumb_mobile),'imagem',TRUE));?>
		<?php } else { ?>
			<?php $_smarty_tpl->_assignInScope('thumb_mobile', $_smarty_tpl->tpl_vars['this']->value->url(array('tipo'=>'sobre','crop'=>1,'largura'=>400,'altura'=>660,'imagem'=>$_smarty_tpl->tpl_vars['sobre']->value->thumb_desktop),'imagem',TRUE));?>
		<?php }?>
		<section class="bloco-sobre">
			<?php if (!empty($_smarty_tpl->tpl_vars['sobre']->value->descricao1)) {?>
				<div class="descricao-1">
					<p><?php echo $_smarty_tpl->tpl_vars['sobre']->value->descricao1;?>
</p>
				</div>
			<?php }?>

			<?php $_smarty_tpl->_assignInScope('desktop_existe', ("common/uploads/sobre/").($_smarty_tpl->tpl_vars['sobre']->value->thumb_desktop));?>
			<?php $_smarty_tpl->_assignInScope('mobile_existe', ("common/uploads/sobre/").($_smarty_tpl->tpl_vars['sobre']->value->thumb_mobile));?>
			<?php if (file_exists($_smarty_tpl->tpl_vars['desktop_existe']->value)) {?>
				<?php $_smarty_tpl->_assignInScope('thumb_desktop', $_smarty_tpl->tpl_vars['this']->value->url(array('tipo'=>'sobre','crop'=>'1','largura'=>1920,'altura'=>1080,'imagem'=>$_smarty_tpl->tpl_vars['sobre']->value->thumb_desktop),'imagem',TRUE));?>
				<?php if (file_exists($_smarty_tpl->tpl_vars['mobile_existe']->value)) {?>
					<?php $_smarty_tpl->_assignInScope('thumb_mobile', $_smarty_tpl->tpl_vars['this']->value->url(array('tipo'=>'sobre','crop'=>'1','largura'=>400,'altura'=>658,'imagem'=>$_smarty_tpl->tpl_vars['sobre']->value->thumb_mobile),'imagem',TRUE));?>
				<?php } else { ?>
					<?php $_smarty_tpl->_assignInScope('thumb_mobile', $_smarty_tpl->tpl_vars['this']->value->url(array('tipo'=>'sobre','crop'=>'1','largura'=>400,'altura'=>658,'imagem'=>$_smarty_tpl->tpl_vars['sobre']->value->thumb_desktop),'imagem',TRUE));?>
				<?php }?>
				<?php $_smarty_tpl->_assignInScope('id_video', $_smarty_tpl->tpl_vars['this']->value->YoutubeId($_smarty_tpl->tpl_vars['sobre']->value->link_video));?>
				<?php if (!empty($_smarty_tpl->tpl_vars['id_video']->value)) {?>
					<div class="video" data-aos="fade-up" data-url="https://www.youtube.com/embed/<?php echo $_smarty_tpl->tpl_vars['id_video']->value;?>
">
						<img class="uk-visible@s thumb" data-src="<?php echo $_smarty_tpl->tpl_vars['thumb_desktop']->value;?>
" data-width="1920" data-height="1080" uk-img
							alt="RkAdvisors">
						<img class="uk-hidden@s thumb" data-src="<?php echo $_smarty_tpl->tpl_vars['thumb_mobile']->value;?>
" data-width="400" data-height="658" uk-img
							alt="RkAdvisors">
						<img class="playButton" src="common/default/images/playvideo.svg" alt="Reproduzir Video">
					</div>
				<?php } else { ?>
					<img class="uk-visible@s" data-src="<?php echo $_smarty_tpl->tpl_vars['thumb_desktop']->value;?>
" data-width="1920" data-height="1080" uk-img
						alt="RkAdvisors">
					<img class="uk-hidden@s" data-src="<?php echo $_smarty_tpl->tpl_vars['thumb_mobile']->value;?>
" data-width="400" data-height="658" uk-img alt="RkAdvisors">
				<?php }?>
			<?php }?>

			<?php if (!empty($_smarty_tpl->tpl_vars['sobre']->value->descricao2)) {?>
				<div class="descricao-2">
					<p><?php echo $_smarty_tpl->tpl_vars['sobre']->value->descricao2;?>
</p>
				</div>
			<?php }?>
		</section>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['proposito']->value->descricao) {?>
		<section class="bloco-proposito">
			<div class="proposito-content" id="proposito">
				<div class="titulo">
					<h2><?php echo $_smarty_tpl->tpl_vars['proposito']->value->titulo;?>
</h2>
				</div>
				<div class="texto">
					<p><?php echo $_smarty_tpl->tpl_vars['proposito']->value->descricao;?>
</p>
				</div>
			</div>
			<div class="botao">
				<input type="checkbox" name="continue-lendo" id="continue-lendo" style="display: none;">
				<label for="continue-lendo" id="proposito-btntext">
					Continue Lendo
				</label>
			</div>
		</section>
	<?php }?>

	<!-- Renderiza caso exista algum Serviço -->
	<?php if (count($_smarty_tpl->tpl_vars['servicos']->value) > 0) {?>
		<section class="bloco-servicos">
			<header class="topo">
				<h2 class="titulo">
					Nossos Serviços
				</h2>
			</header>
			<div class="slides uk-visible@m" 
					data-slide='{"autoplay":{"delay":5000}, "watchOverflow":false, "spaceBetween":10, "slidesPerView": 2, "slidesPerGroup":1, "breakpoints":{"900":{"slidesPerView":2, "slidesPerGroup":2}}}'
				>

				<div class="grid-container swiper-container">
					<div class="swiper-wrapper">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['servicos']->value, 'itemservico');
$_smarty_tpl->tpl_vars['itemservico']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['itemservico']->value) {
$_smarty_tpl->tpl_vars['itemservico']->do_else = false;
?>
							<a class="item swiper-slide" href="<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
/servico/<?php echo $_smarty_tpl->tpl_vars['itemservico']->value->idservico;?>
">
								<main class="content">
									<?php $_smarty_tpl->_assignInScope('imagem_banner', $_smarty_tpl->tpl_vars['this']->value->url(array('tipo'=>'servicos','crop'=>'1','largura'=>530,'altura'=>380,'imagem'=>$_smarty_tpl->tpl_vars['itemservico']->value->banner),'imagem',TRUE));?>
									<img src=<?php echo $_smarty_tpl->tpl_vars['imagem_banner']->value;?>
 alt=<?php echo $_smarty_tpl->tpl_vars['itemservico']->value->titulo;?>
>
									<div class="titulo-servico">
										<h2 class="titulo"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['itemservico']->value->titulo,40,"...");?>
</h2>
									</div>
								</main>
							</a>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</div>
					<div class="swiper-pagination"></div>
				</div>

			</div>
			<div class="grid uk-hidden@m">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['servicos']->value, 'itemservico');
$_smarty_tpl->tpl_vars['itemservico']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['itemservico']->value) {
$_smarty_tpl->tpl_vars['itemservico']->do_else = false;
?>
					<a class="item swiper-slide" href="<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
/servico/<?php echo $_smarty_tpl->tpl_vars['itemservico']->value->idservico;?>
">
						<main class="content">
							<?php $_smarty_tpl->_assignInScope('imagem_banner', $_smarty_tpl->tpl_vars['this']->value->url(array('tipo'=>'servicos','crop'=>'1','largura'=>320,'altura'=>280,'imagem'=>$_smarty_tpl->tpl_vars['itemservico']->value->banner_mobile),'imagem',TRUE));?>
							<img src=<?php echo $_smarty_tpl->tpl_vars['imagem_banner']->value;?>
 alt=<?php echo $_smarty_tpl->tpl_vars['itemservico']->value->titulo;?>
>
							<div class="titulo-servico">
								<h2 class="titulo"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['itemservico']->value->titulo,40,"...");?>
</h2>
							</div>
						</main>
					</a>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			</div>
		</section>
	<?php }?>


	<!-- Renderiza caso exista algum Serviço -->
	<?php if (count($_smarty_tpl->tpl_vars['servicos']->value) > 0) {?>
		<section class="bloco-blog">
			<div class="slides" 
					data-slide='{"autoplay":{"delay":10000}, "watchOverflow":false, "spaceBetween":0, "slidesPerView": 1, "slidesPerGroup":1, "breakpoints":{"900":{"slidesPerView":1, "slidesPerGroup":1}}}'
				>

				<div class="grid-container swiper-container">
					<div class="swiper-wrapper">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['noticias']->value, 'itemnoticia');
$_smarty_tpl->tpl_vars['itemnoticia']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['itemnoticia']->value) {
$_smarty_tpl->tpl_vars['itemnoticia']->do_else = false;
?>
							<div class="item swiper-slide">
								<?php $_smarty_tpl->_assignInScope('banner_desktop', $_smarty_tpl->tpl_vars['this']->value->url(array('tipo'=>'blog','crop'=>'1','largura'=>480,'altura'=>480,'imagem'=>$_smarty_tpl->tpl_vars['itemnoticia']->value->imagem_capa_desktop),'imagem',TRUE));?>
								<figure class="imagem-noticia">
									<img src=<?php echo $_smarty_tpl->tpl_vars['banner_desktop']->value;?>
 alt=<?php echo $_smarty_tpl->tpl_vars['itemnoticia']->value->titulo;?>
>
								</figure>
								<main class="content">
									<h2><?php echo $_smarty_tpl->tpl_vars['itemnoticia']->value->titulo;?>
</h2>
									<p><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['itemnoticia']->value->texto,400,"...");?>
</p>
									<a
										href="<?php echo url('noticia',array('idnoticia'=>$_smarty_tpl->tpl_vars['itemnoticia']->value->idblog,'slug'=>$_smarty_tpl->tpl_vars['this']->value->createslug($_smarty_tpl->tpl_vars['itemnoticia']->value->titulo)));?>
">Ler
										Notícia</a>
								</main>
							</div>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</div>
					<div class="swiper-pagination"></div>
					<div class="swiper-button-prev uk-visible@m"></div>
					<div class="swiper-button-next uk-visible@m"></div>
				</div>
			</div>
		</section>
	<?php }?>

	<section class="bloco-email">
		<form method="post" action="<?php echo url('ajax-newsletter');?>
" data-validate="ajax">
			<div class="input-container">
				<div>
					<figure class="icone"><i class="icon-email"></i></figure>
					<input type="email" name="email" class="uk-input" id="email"
						placeholder="INSIRA SEU E-MAIL E RECEBA NOSSAS NOVIDADES" maxlength="150" required>
				</div>
				<button type="submit" class="uk-button uk-button-primary btn-enviar">INSCREVER</button>
			</div>
		</form>
	</section>
</main>
<?php }
}
