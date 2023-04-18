Pseudokod Card Game (kmom03)
===========

BEGIN
    Player draws card
        calculate player points
        save player points
    IF player has more than 21 points THEN
        show bank cards
        read points (and display)
        end game
        player lost game
    ELSE
        player can draw card or stop
    ENDIF
END

BEGIN
    Player stops (has less than 21)
    Bank draws a card
        calculate bank points
        save bank points
    WHILE bank points is less than 17
        bank draws another card
        calculate bank points
        save bank points
    ENDWHILE
    Bank stops (has more than 17)
    Show bank cards
    Read points (and display)
        IF bank has more than 21 points THEN
            end game
            player won game
        ELSEIF player has more points than bank THEN
            end game
            player won game
        ELSE
            end game
            player lost game
        ENDIF
END
