<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
            <h4 class="modal-title"> <i class="glyphicon glyphicon-stats"></i> User Stats</h4>
        </div>
        <table id="load_datatable" class="table table-colored table-inverse table-hover table-striped table-bordered">
            <thead>
            <tr>
                <th>Templates</th>
                <th>Opened</th>
                <th>Clicked</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= $templates ?></td>
                <td><?= $opened ?></td>
                <td><?= $clicked ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>