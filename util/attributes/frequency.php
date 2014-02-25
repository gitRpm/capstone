<?php
class frequency {
    
    public function getFrequencies() {
        $con = new connection();
         // get the frequencies
        $this->stmt = $con->con->prepare("SELECT frequency_type_id, frequency_type_display FROM frequency_type ORDER BY frequency_type_id ASC;");
        $this->stmt->execute();
        $this->stmt->bind_result($frequencyId, $frequencyDisplay);

        while ($this->stmt->fetch()) {
            $frequency[$frequencyId] = $frequencyDisplay;
        }
        $this->stmt->close();
        return $frequency;
    }
}
