<div class="container">

    <?php $this->renderFeedbackMessages(); ?>

    <h1>Message/index</h1>

    <section class="discussion">

        <?php
        $count = 0;
        foreach ($this->messages as $index => $message) {

            $textClass = "";

            if ($message['SenderID'] == $this->receiverID)
                $textClass = "recipient";
            else
                $textClass = "sender";

            if (isset($this->messages[$index + 1]) && $this->messages[$index + 1]['SenderID'] == $message['SenderID']) {
                switch ($count) {
                    case 0:
                        $textClass .= " first";
                        break;
                    case 1:
                        $textClass .= " middle";
                        break;
                }
                $count = 1;
            } else {
                switch ($count) {
                    case 1:
                        $textClass .= " last";
                        $count = 1;
                        break;
                }
                $count = 0;
            }

            echo '<div class="bubble ' . $textClass . '">' . $message['MessageText'] . '</div>';
            echo '<div class="message-time ' . $textClass . '">' . $message['Time'] . '</div>';
        }
        ?>

        <!-- <div class="bubble sender first">Hello</div>
        <div class="bubble sender last">This is a CSS demo of the Messenger chat bubbles, that merge when stacked together.</div>

        <div class="bubble recipient first">Oh that's cool!</div>
        <div class="bubble recipient last">Did you use JavaScript to perform that kind of effect?</div>

        <div class="bubble sender first">No, that's full CSS3!</div>
        <div class="bubble sender middle">(Take a look to the 'JS' section of this Pen... it's empty! 😃</div>
        <div class="bubble sender last">And it's also really lightweight!</div>

        <div class="bubble recipient">Dope!</div>

        <div class="bubble sender first">Yeah, but I still didn't succeed to get rid of these stupid .first and .last classes.</div>
        <div class="bubble sender middle">The only solution I see is using JS, or a d i v; to group elements together, but I don't want to ...</div>
        <div class="bubble sender last">I think it's more transparent and easier to group .bubble elements in the same parent.</div> -->
        <div>
            <p>
            <form method="post" action="<?php echo Config::get('URL'); ?>message/send/<?php echo $this->receiverID ?>">
                <input type="text" name="messageText">
                <input type="submit" value='Send message' autocomplete="off" />
            </form>
            </>
        </div>
    </section>

</div>