<!-- fullname -->
<div class="col-md-12 mb-3">
    <div class="input-group input-group-sm ">
        <spam class="input-group-text"><i class="bi bi-person"></i></spam>
        <input type="text" class="form-control <?= isset($err->fullname) ? 'is-invalid' : '' ?>" name="fullname" placeholder="Nombre Completo" value="<?= isset($data->fullname) ? $data->fullname : '' ?>">
        <?php if (isset($err->fullname)) : ?>
            <div class="invalid-feedback">
                <?= $err->fullname ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- email -->
<div class="col-md-6 mb-3">
    <div class="input-group input-group-sm ">
        <spam class="input-group-text"><i class="bi bi-envelope"></i></spam>
        <input type="text" class="form-control <?= isset($err->email) ? 'is-invalid' : '' ?>" name="email" placeholder="Ingrese el Email" value="<?= isset($data->email) ? $data->email : '' ?>">
        <?php if (isset($err->email)) : ?>
            <div class="invalid-feedback">
                <?= $err->email ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- password -->
<div class="col-md-6 mb-3">
    <div class="input-group input-group-sm ">
        <spam class="input-group-text"><i class="bi bi-key"></i></spam>
        <input type="password" class="form-control <?= isset($err->password) ? 'is-invalid' : '' ?>" name="password" placeholder="Ingrese la contraseña">
        <?php if (isset($err->password)) : ?>
            <div class="invalid-feedback">
                <?= $err->password ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- school_id -->
<div class="col-md-6 mb-3">
    <div class="input-group  input-group-sm  mb-3">
        <spam class="input-group-text"><i class="bi bi-house-fill"></i></spam>
        <select class="form-select flex-grow-1 <?= isset($err->school_id) ? 'is-invalid' : '' ?>" name="school_id">
            <option value="">Seleccione Escuela</option>
            <?php foreach ($schools as $school) : ?>
                <option <?= isset($data->school_id) && $data->school_id == $school->id ? 'selected' : '' ?> value="<?= $school->id; ?>"><?= $school->name; ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($err->school_id)) : ?>
            <div class="invalid-feedback">
                <?= $err->school_id ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- rol-id -->
<div class="col-md-6">
    <div class="input-group  input-group-sm  mb-3">
        <spam class="input-group-text"><i class="bi bi-person-lines-fill"></i></spam>
        <select class="form-select flex-grow-1 <?= isset($err->rol_id) ? 'is-invalid' : '' ?>" name="rol_id">
            <option value="">Seleccione Rol</option>
            <?php foreach ($roles as $rol) : ?>
                <option <?= isset($data->rol_id) && $data->rol_id == $rol->id ? 'selected' : '' ?> value="<?= $rol->id; ?>"><?= $rol->rol_name; ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($err->rol_id)) : ?>
            <div class="invalid-feedback">
                <?= $err->rol_id ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- estado -->
<div class="col-md-6">
    <div class="input-group input-group-sm ">
        <spam class="input-group-text"><i class="bi bi-shield-lock"></i></spam>
        <div class="form-control  <?= isset($err->status) ? 'is-invalid' : '' ?>">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="estado1" value="1" <?= (isset($data->status) && $data->status == 1) ? 'checked' : '' ?>>
                <label class="form-check-label" for="estado1">Habilitar</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="estado2" value="0" <?= (isset($data->status) && $data->status == 0) ? 'checked' : '' ?>>
                <label class="form-check-label" for="estado2">Inhabilitar</label>
            </div>
        </div>
        <?php if (isset($err->status)) : ?>
            <div class="invalid-feedback">
                <?= $err->status ?>
            </div>
        <?php endif; ?>
    </div>
</div>


<input type="hidden" name="id" value="<?= isset($data->id) ? $data->id : '' ?>">