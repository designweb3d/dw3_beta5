function InitAudio (current_id) {

        // The number of bars that should be displayed
        const NBR_OF_BARS = 36;

        // Get the audio element tag
        const audio = document.getElementById("audio_control_"+current_id);
        audio.style.display = "inline-block";
        document.getElementById("audio_start_"+current_id).style.display = "none";
        // Create an audio context
        const ctx = new AudioContext();

        // Create an audio source
        const audioSource = ctx.createMediaElementSource(audio);

        // Create an audio analyzer
        const analayzer = ctx.createAnalyser();

        // Connect the source, to the analyzer, and then back the the context's destination
        audioSource.connect(analayzer);
        audioSource.connect(ctx.destination);

        // Print the analyze frequencies
        const frequencyData = new Uint8Array(analayzer.frequencyBinCount);
        analayzer.getByteFrequencyData(frequencyData);
        //console.log("frequencyData", frequencyData);

        // Get the visualizer container
        const visualizerContainer = document.getElementById("audio_container_"+current_id);

        // Create a set of pre-defined bars
        for( let i = 0; i < NBR_OF_BARS; i++ ) {

            const bar = document.createElement("DIV");
            bar.setAttribute("id", "bar_"+current_id+"_" + i);
            bar.style.display = "inline-block";
            bar.style.margin = "0 2px";
            bar.style.width = "1.4vw";
            bar.style.backgroundColor = "#FFF";
            bar.style.mixBlendMode = "invert(80%)";
            bar.style.verticalAlign = "top";
            visualizerContainer.appendChild(bar);

        }

        // This function has the task to adjust the bar heights according to the frequency data
        function renderFrame() {

            // Update our frequency data array with the latest frequency data
            analayzer.getByteFrequencyData(frequencyData);

            for( let i = 0; i < NBR_OF_BARS; i++ ) {

                // Since the frequency data array is 1024 in length, we don't want to fetch
                // the first NBR_OF_BARS of values, but try and grab frequencies over the whole spectrum
                const index = (i + 10) * 2;
                // fd is a frequency value between 0 and 255
                const fd = frequencyData[index];

                // Fetch the bar DIV element
                const bar = document.querySelector("#bar_"+current_id + "_" + i);
                if( !bar ) {
                    continue;
                }

                // If fd is undefined, default to 0, then make sure fd is at least 4
                // This will make make a quiet frequency at least 4px high for visual effects
                const barHeight = Math.max(4, fd || 0);
                bar.style.height = barHeight + "px";

            }

            // At the next animation frame, call ourselves
            window.requestAnimationFrame(renderFrame);

        }

        renderFrame();

        audio.volume = 0.10;
        audio.play();

}