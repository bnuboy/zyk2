<div class="databox1" style=" padding-top:8px;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th width="193">课堂名称</th>
                <th width="234">创建时间</th>
                <th width="75">状态</th>
            </tr>
        </thead>
        <tbody id="resousdata">
            <?php
            foreach ( $list as $k => $v )
            {
               
            ?>
                <tr>
                    <td><?= $v[ 'name' ]; ?></td>
                    <td><?= date( 'Y-m-d', strtotime( $v[ 'created' ] ) ); ?></td>
                <td>
                    <?
                    if ( $v[ 'status' ] == 'wait' )
                    {
                        echo "待审核";
                    }
                    else if ( $v[ 'status' ] == 'audit' )
                    {
                        echo "<span class='greenm'>审核通过</span>";
                    }
                    ?>
                    </td>
<?php } ?>
            </tr>
        </tbody>
    </table>
</div>
