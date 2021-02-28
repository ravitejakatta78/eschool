<table id="tblAddRowsupdate" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>S.No.</th>
            <th>Student Name</th>
            <?php foreach($subjects as $sub){ ?>
                <th><?= $sub['subject_name']; ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody class="list">
        <?php $studentcount = count($students);
            for($i=0;$i < $studentcount ; $i++ ){ 
                $studentMarkMainArr = $marks[$students[$i]['id']];
                $newMarksArr = array_column($studentMarkMainArr,'marks','subject_id'); 
                ?> 
                <tr>
                    <td><?= ($i+1) ;?></td>
                    <td>
                        <?= $students[$i]['first_name'].' '.$students[$i]['last_name'];?>
                        <input type="hidden" name="student_id[]" value="<?= $students[$i]['id'] ?>" class="form-control">
                    </td>
                    <?php foreach($subjects as $sub){ ?>
                    <td>
                        <input type="text" name="subject_<?=$sub['id'] ?>[]" 
                               value="<?php echo $newMarksArr[$sub['id']] ?? ''; ?>" class="form-control" disabled="true">
                    </td>
                    <?php } ?>
                </tr>
      <?php } ?>
    </tbody>
</table>