<script>
    $(document).ready(function() {
        var totalSamples = $('#total-samples').text();
        var totalSecs = $('#total-seconds').text();
        var totalEmbedded = $('.total-embedded').first().text();

        if (totalSamples > 0 && totalSecs > 0) {
            var tp = totalSamples / totalSecs;
            tp = Math.round(tp) + '';
            tp = tp.replace('.', ',');
            
            $('#data').prepend('<div class="alert alert-error">A taxa de processamento por segundo (Throughput) da página testada foi de ' + tp + '.</div>');
        }
        
        if (totalEmbedded > 0) {
            $('#data').prepend('<div class="alert alert-error">Foram carregados ' + totalEmbedded + ' recursos externos na página testada.</div>');
        } 
        
        $('#data').prepend('<br/>');
    });
</script>
<?php echo $report ?>
