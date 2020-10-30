<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
	<form class="form-inline mr-auto">
		<ul class="navbar-nav mr-3">
			<li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
		</ul>
	</form>

	<ul class="navbar-nav navbar-right">
		<li class="dropdown">
			<a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
				<img alt="image" src="<?= base_url('img/admin/avatar-1.png') ?>" class="rounded-circle mr-1">
				<div class="d-sm-none d-lg-inline-block"><?= $this->session->userdata('admin_name'); ?></div>
			</a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="#modal_pass_change" data-toggle="modal" class="dropdown-item has-icon">
					<i class="fas fa-key"></i>パスワード変更
				</a>
				<div class="dropdown-divider"></div>
				<a href="<?= site_url('admin/index/logout') ?>" class="dropdown-item has-icon text-danger">
					<i class="fas fa-sign-out-alt"></i>ログアウト
				</a>
			</div>
		</li>
	</ul>
</nav>

<?php /* パスワード変更ダイアログ */ ?>
<div class="modal" id="modal_pass_change" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">パスワード変更</h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&#215;</span><span class="sr-only">閉じる</span>
				</button>
			</div><!-- /modal-header -->

			<div class="modal-body">
				<div class="row">
					<div class="col-sm-4">
						現在のパスワード
					</div>
					<div class="col-sm-8">
						<?php echo form_input(array(
							'name'		=> 'old_pass',
							'id'		=> 'old_pass',
							'type'		=> 'text',
							'value'		=> '',
							'maxlength'	=> 255
						)); ?>
					</div>
				</div><br />
				<div class="row">
					<div class="col-sm-4">
						新しいパスワード
					</div>
					<div class="col-sm-8">
						<?php echo form_input(array(
							'name'		=> 'new_pass',
							'id'		=> 'new_pass',
							'type'		=> 'text',
							'value'		=> '',
							'maxlength'	=> 255
						)); ?>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
				<button type="button" class="btn btn-primary" onclick="password_change();">変更</button>
			</div>
		</div> <!-- /.modal-content -->
	</div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->

<?php /* メッセージ表示ダイアログ */ ?>
<div class="modal" id="modal_message_box" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-show="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modal_title"></h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&#215;</span><span class="sr-only">閉じる</span>
				</button>
			</div><!-- /modal-header -->

			<div class="modal-body">
				<p id="modal_body"></p>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-dismiss="modal">閉じる</button>
				<button type="button" class="btn btn-primary" onclick="act();" id="modal_act"></button>
			</div>
		</div> <!-- /.modal-content -->
	</div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->
