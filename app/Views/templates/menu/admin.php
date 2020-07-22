<!-- A wrapper to easily create bootstrap modals from JS -->
<script src="/assets/bootstrap-model-wrapper.js"></script>

<!-- flatpickr dependencies -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!--  Default HTML does not contain a multiselect, include one -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-multiselect@0.9.15/dist/js/bootstrap-multiselect.min.js"
            integrity="sha256-NNTJMfCjKMElj34Oh2XgoYhoaN6UzMjeTtEXo2c2TZc=" crossorigin="anonymous"></script>

<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.js"></script>

<script src="/assets/hydrofiel-admin.js"></script>

<div class="banner">
    <div class="header">
        <nav class="navbar navbar-expand-xl navbar-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#hydrofiel-nav" aria-controls="hydrofiel-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="hydrofiel-nav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="/admin" class="nav-link">Pagina</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/posts" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/uploads" class="nav-link">Uploaden</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/events" class="nav-link">Agenda</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/mail" class="nav-link">Mail</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/users" class="nav-link">Leden</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">Terug</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="banner-info" id="info">
        <p><?= lang('General.generalInfo') ?></p>
        <h2>N.S.Z.&W.V. Hydrofiel</h2>
    </div>
</div>
<div class="container pt-3">
    <?php if (session('success')) { ?>
        <div class="alert alert-success">
            <strong><?= session('success') ?></strong>
        </div>
    <?php } elseif (session('error')) { ?>
        <div class="alert alert-danger">
            <strong><?= session('error') ?></strong>
        </div>
    <?php } ?>
