<div class="content" id="fotos">
    <div class="row">
        <input id="id" type="hidden" value="{$id}">

        <div class="small-12 medium-6 large-4 end columns">
            <div class="arquivo-upload-avancado" data-upload-url="{$this->url(['module'=>'admin', 'controller'=>$controller, 'action'=>'upload'], 'default', TRUE)}" data-campo-ref-name="fotos">
                <div class="arquivo_tmp btn btn-indigo btn-text-uppercase">
                    <div class="solte-arquivos">Selecione ou solte aqui <span class="input-file-upload"></span></div>
                </div>
                <div class="dimensoes">
                    <span class="font-medium">Resolução: 1920x1080. Extensões [.jpg][.png]</span>
                </div>
                <div class="arquivos-enviados"></div>
                <input type="file" name="fotos[]" id="fotos[]" multiple tabindex="-1" autocomplete="off" accept="">
            </div>
        </div>

        <div class="small-12 columns">
            <p><b>*</b> Após enviar as imagens, clique em <b>atualizar</b> para salvar</p>
            <p><b>*</b> Clique e arraste para ordenar as imagens</p>
        </div>

        {if !$fotos|count}
            <div class="small-12 columns no-photos">
                <p>(nenhuma imagem cadastrada)</p>
            </div>
        {/if}

        <div class="small-12 columns linha-fotos">
            <ul class="photos no-bullet row small-up-1 medium-up-3 large-up-4" data-order-url="{$basePath}/admin/{$controller}/salvaordemimage">
                {foreach from=$fotos item="row"}
					{if !empty($row->imagem)}
						{assign var="img_existe" value="common/uploads/"|cat:$row->folder|cat:"/"|cat:$row->imagem}
						{if file_exists($img_existe)}
							{assign var="src_img" value=$this->url(['tipo'=>$row->folder, 'crop'=>2, 'largura'=>220, 'altura'=>220, 'imagem'=>$row->imagem], 'imagem', TRUE)}
							<li class="column" id="{$row->idmediagallery}">
								<div class="panel">
									<div class="row collapse">
										<div class="small-12 columns acoes-galeria">
											<a data-src="{$basePath}/admin/{$controller}/removeimage/id/{$id}/iditem/{$row->idmediagallery}/foto/{$row->imagem}" class="btn-remove-image" title="Excluir">
												<span class="delete"></span>
											</a>
											<a class="icon-preview" href="{$this->url(['tipo'=>$row->folder, 'crop'=>2, 'largura'=>0, 'altura'=>0, 'imagem'=>$row->imagem], 'imagem', TRUE)}" data-fancybox="preview-by-buttons">
												<span class="preview"></span>
											</a>
											<div class="capa-image">
												<span class="star"></span>
											</div>
										</div>
										<div class="small-12 columns text-center imagem">
											<a href="{$this->url(['tipo'=>$row->folder, 'crop'=>2, 'largura'=>0, 'altura'=>0, 'imagem'=>$row->imagem], 'imagem', TRUE)}" data-fancybox="preview">
												<img src="{$src_img}" alt="Thumb">
											</a>
										</div>
									</div>
								</div>
							</li>
						{/if}
					{else}
						{if !empty($row->url)}
							<!--Função validar url da imagem-->
                            {if file_get_contents($row->url) == false}
                                {*não existe*}
                            {else}
								<li class="column" id="{$row->idmediagallery}">
									<div class="panel">
										<div class="row collapse">
											<div class="small-12 columns acoes-galeria">
												<a data-src="{$basePath}/admin/{$controller}/removeimage/id/{$id}/iditem/{$row->idmediagallery}" class="btn-remove-image" title="Excluir">
													<span class="delete"></span>
												</a>
												<a class="icon-preview" href="{$row->url}" data-fancybox="preview-by-buttons">
													<span class="preview"></span>
												</a>
												<div class="capa-image">
													<span class="star"></span>
												</div>
											</div>
											<div class="small-12 columns text-center imagem">
												<a href="{$row->url}" data-fancybox="preview">
													<img src="{$row->url}" alt="Thumb">
												</a>
											</div>
											{* <div class="small-12 columns legenda">
												<div class="element-form">
													<div class="labeldiv">
														<label for="img_legenda_{$row->idmediagallery}">Legenda</label>
													</div>
													<div class="input-form">
														<input type="text" name="img_legenda" id="img_legenda_{$row->idmediagallery}" value="{$row['legenda']}" class="varchar string legenda" data-iditem="{$row->idmediagallery}" data-url="{$basePath}/admin/{$controller}/salvalegenda">
													</div>
												</div>
											</div> *}
										</div>
									</div>
								</li>
							{/if}
						{/if}
					{/if}
                {/foreach}
            </ul>
        </div>
    </div>
</div>

<div class="content" id="videos">
    <div class="element-form" id="element-video_arquivo">
        <div class="row">
            <div class="small-6 medium-2 large-2 columns labeldiv" id="label-video_arquivo">
                <label for="video_arquivo" class="optional">Thumb<div class="clearfix"></div>
                    <small>Extensões [.jpg][.png]</small>
                </label>
            </div>
            <div class="input-form small-12 medium-6 large-6 columns end">
                <label class="input-file-upload expand button">
                    <span>Selecione a thumb</span>
                    <input name="video_arquivo" id="video_arquivo" field-type="file" class="varchar file radius" type="file">
                </label>
            </div>
        </div>
    </div>

    <div class="element-form" id="element-video_url">
        <div class="row">
            <div class="small-6 medium-2 large-2 columns labeldiv" id="label-video_url">
                <label for="video_url" class="required">URL do vídeo *<div class="clearfix"></div>
                    <small></small>
                </label>
            </div>
            <div class="input-form small-12 medium-6 large-6 columns end">
                <input name="video_url" id="video_url" value="" field-type="text" class="varchar string radius" type="text">
            </div>
        </div>
    </div>

    <div class="element-form" id="element-video_nova_legenda">
        <div class="row">
            <div class="small-6 medium-2 large-2 columns labeldiv" id="label-video_nova_legenda">
                <label for="video_nova_legenda" class="optional">Legenda<div class="clearfix"></div>
                    <small></small>
                </label>
            </div>
            <div class="input-form small-12 medium-6 large-6 columns end">
                <input name="video_nova_legenda" id="video_nova_legenda" value="" field-type="text" class="varchar string radius" type="text">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-12 columns end">
            <a href="#" class="button secondary normal btn-add-video"><span class="mdi mdi-content-save-move-outline"></span> Adicionar vídeo</a>
        </div>
    </div>

    <div class="row">
        <hr>
        {if !$videos|count}
            <div class="small-12 columns no-videos">
                <p>(nenhum vídeo cadastrado)</p>
            </div>
        {/if}

        <div class="small-12 columns linha-fotos">
            <ul class="photos no-bullet row small-up-1 medium-up-3 large-up-4" data-order-url="{$basePath}/admin/{$controller}/salvaordem/">
                {foreach from=$videos item="row"}
                    {assign var="id_video" value=$this->YoutubeId($row->url)}
                    {if !empty($row->url)}
                        <li class="column end" id="{$row->idmediagallery}">
                            <div class="panel">
                                <div class="row collapse">
                                    <div class="small-12 columns acoes-galeria">
                                        <a href="{$basePath}/admin/{$controller}/removevideo/id/{$id}/iditem/{$row->idmediagallery}/foto/{$row->imagem}" class="btn-remove-video" title="Excluir">
                                            <span class="delete"></span>
                                        </a>
										{if !empty($id_video)}
                                        	<a class="icon-preview video-admin item-preview-video" href="https://www.youtube.com/watch?v={$id_video}" target="_blank" title="Visualizar">
										{else}
											<a class="icon-preview" href="{$row->url}" target="_blank" title="Visualizar">
										{/if}
                                            <span class="preview"></span>
                                        </a>
                                    </div>
                                    <div class="small-12 columns text-center imagem">
										{if !empty($id_video)}
                                        	<a href="https://www.youtube.com/watch?v={$id_video}" target="_blank" class="video-admin item-preview-video" title="{$row->legenda}">
										{else}
											<a href="{$row->url}" target="_blank" title="{$row->legenda}">
										{/if}
                                            {assign var="img_existe" value="common/uploads/"|cat:$row->folder|cat:"/"|cat:$row->imagem}
                                            {if file_exists($img_existe) && !empty($row->imagem)}
                                                <img src="{$this->url(['tipo'=>$row->folder, 'crop'=>2, 'largura'=>480, 'altura'=>360, 'imagem'=>$row->imagem], 'imagem', TRUE)}" alt="Thumb video">
                                            {else}
                                                {assign var="thumb_video" value=$this->YoutubeId($row->url, 'thumb', 'big')}
												{if empty($thumb_video)}
													{$thumb_video = $this->url(['tipo'=>'default', 'crop'=>2, 'largura'=>480, 'altura'=>360, 'imagem'=>'not_found_img2.jpg'], 'imagem', TRUE)}
												{/if}
                                                <img src="{$thumb_video}" width="480" height="360" alt="Thumb video">
                                            {/if}
                                        </a>
                                    </div>
                                    <div class="small-12 columns legenda">
                                        <div class="element-form">
                                            <div class="labeldiv">
                                                <label for="img_legenda_{$row->idmediagallery}">Legenda</label>
                                            </div>
                                            <div class="input-form">
                                                <input type="text" name="video_legenda" id="video_legenda_{$row->idmediagallery}" value="{$row->legenda}" class="varchar string legenda" data-iditem="{$row->idmediagallery}" data-url="{$basePath}/admin/{$controller}/salvalegenda/">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    {/if}
                {/foreach}
            </ul>
        </div>
    </div>
</div>

<div class="content" id="downloads">
    <div class="element-form" id="element-doc_arquivo">
        <div class="row">
            <div class="small-6 medium-2 large-2 columns labeldiv" id="label-doc_arquivo">
                <label for="doc_arquivo" class="required">Arquivo *<div class="clearfix"></div>
                    <small>Extensões<br>[.pdf][.zip][.doc][.xls][.jpg][.png]</small>
                </label>
            </div>
            <div class="input-form small-12 medium-6 large-6 columns end">
                <label class="input-file-upload expand button">
                    <span>Selecione um arquivo</span>
                    <input name="doc_arquivo" id="doc_arquivo" field-type="file" class="varchar file radius" type="file">
                </label>
            </div>
        </div>
    </div>

    <div class="element-form" id="element-doc_titulo">
        <div class="row">
            <div class="small-6 medium-2 large-2 columns labeldiv" id="label-doc_titulo">
                <label for="doc_titulo" class="optional">Título<div class="clearfix"></div>
                    <small></small>
                </label>
            </div>
            <div class="input-form small-12 medium-6 large-6 columns end">
                <input name="doc_titulo" id="doc_titulo" value="" field-type="text" class="varchar string radius" type="text">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-12 columns end">
            <a href="#" class="button secondary normal btn-add-arquivo"><span class="mdi mdi-content-save-move-outline"></span> Adicionar arquivo</a>
        </div>
    </div>

    <div class="row">
        <hr>
        {if !$downloads|count}
            <div class="small-12 columns no-arquivos">
                <p>(nenhum arquivo cadastrado)</p>
            </div>
        {/if}

        <div class="small-12 columns arquivos lista-simples">
            {if $downloads|count > 0}
                <h2>Arquivos existentes</h2>
            {/if}
            {foreach from=$downloads item="row"}
                <div class="row arquivo-container lista-simples-item">
                    <a href="{$basePath}/admin/{$controller}/deletardownload/id/{$id}/iditem/{$row->idmediagallery}/arquivo/{$row->file_arquivo}" class="btn-remove-arquivo" title="Excluir">
                        <span class="delete"></span>
                    </a>
                    <a class="icon-preview" href="{$basePath}/common/uploads/{$row->folder}/{$row->file_arquivo}" target="_blank" title="Visualizar">
                        <span class="preview"></span>
                    </a>

                    <div class="nome">
                        {assign var="arr_download" value="."|explode:$row->file_arquivo}
                        {assign var="doc_extensao" value=$arr_download|@end}
                        <span>{$row->txt_arquivo} (.{$doc_extensao})</span>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
    <iframe name="uploadthumb-frame" class="hide"></iframe>
    <form target="uploadthumb-frame" action="{$this->url(['module'=>'admin', 'controller'=>$controller, 'action'=>'uploadthumb'], 'default', TRUE)}" id="form-uploadthumb" method="post" enctype="multipart/form-data"></form>

    <iframe name="uploadarquivo-frame" class="hide"></iframe>
    <form target="uploadarquivo-frame" action="{$this->url(['module'=>'admin', 'controller'=>$controller, 'action'=>'uploadarquivo'], 'default', TRUE)}" id="form-uploadarquivo" method="post" enctype="multipart/form-data"></form>
</div>
