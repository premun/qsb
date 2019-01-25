# Quadra Speed Boosters

Source code of an online web game Quadra Speed Boosters.

## History & disclaimer

Quadra Speed Boosters was a web online game (think Travian, but way older) that I created when I was 14 or 15 years old.
I worked on it for about 4-5 more years but roughly in 2012 discontinued it due to a lack of time after I started university.

This is the original PHP source code of the game.
It is written in Czech language, so variable names and contents are mostly in Czech.

Please take into consideration that it was written 12 years ago by a 14 year old boy.
Almost everything is DIY, PHP 4 was a new thing by then and most of the game was written before all the jQuery hype began.
It (hopefully) does not represent my today coding abilities.

## Community
QSB had over 2500+ registrations and many daily active users.
The community around QSB was extraordinarily nice.
Players were actively taking part in making up features and rules for the game.
Some players took the game quite seriously, many were role playing and creating a really nice environment, that was fueling the development of the game.
There was only one active developer and one lazy admin ;)

Players were writing stories from the QSB world, interviews, tutorials and other experiences and publishing it at the QSB World blog, which was written for this game (again, DIY attitude).
There were player meet-ups happening and they, from time to time, still happen :)

## Screenshots
[This is what the game looked like, before it was taken down.](http://web.archive.org/web/20120507033439/http://qsb.cz/)
[Some screenshots can be found here too](http://web.archive.org/web/20130308084552/http://www.qsb.cz/obrazky-ze-hry).

This repo also contains some, check the [images](https://github.com/premun/qsb/tree/master/images) dir.

## About the game

The game is situated in a Star Wars themed world, more precisely Tatooine [pod racing](http://vignette1.wikia.nocookie.net/starwars/images/b/b1/PodracerAnakin.jpg/revision/latest?cb=20111205042103). 
In the game, you can play as either a pod racer, a bookmaker, a merchant or a mix of these styles.

### Basics
- The game is split up into roughly 2 months long periods. The game is restarted each period and everyone starts from scratch. Only some longtime stats are preserved.
- Each period, you get to choose from 12 different space races (races as in alien breeds, don't mix with race as in contest), each has some RPG qualities (aggresivity, reflexes and trading).
- Every day, there are calculations (13:00, 16:00, 19:00 and main at 23:00). During these, races are simulated and other things are happening.

### Pods
- Racers [build pods](https://github.com/premun/qsb/blob/master/images/depo.png) out of 10 different engine parts
- There are over 300 items to choose from
- Racers can buy these parts either from NPCs or from other players (at a better price, there is an open market)
- Each pod has many parameters (weight, top speed, turning, endurance...)
- Some parts require cooling, some require energy
- You have to plug in a cooler and a power source, so that you meet these requirements
- Not meeting these requirements can result in problems when racing (chance of overload or overheating)

- Heavy more endurant pods cause and take less damage, but are slower
- Fast, light pods don't endure much
- Good equipment comes with high weight/cooling/energy price, it is quite hard to make a good mix.
- Users can save pod templates and switch different items quickly

### Merchants
- You can use the trading skill of your race (again, as in breed) to buy items cheaply from NPCs
- You can sell these items to players, who have worse trading skill
- This is a win-win, since you can make money off and the player gets the item cheaper than from NPCs

### Repairs
- Pods get damaged when racing, either from other racers, from crashing or by just wearing off
- You have to repair your parts so they don't loose efficiency
- Repairing costs money and takes time (real world time)
- You can buy pit droids that speed up repairs and make it cheaper (or both)
- As a merchant, you can buy pit droids cheaply and pose as a repairer
- Players can get their items repaired by you, again a win-win situation
- You can win R2D2 or C3PO in a special race :)

### Races
- Racers enter races. Races are thrown by the system or by other players
- Each race is happening on a user created tracks, and has prize money (or prize items)
- Depending on how interesting the race is (crashes, hard track, big prize money...), throwing of races can also earn you money
- Races have many parameters restricting who can attend, so that only people of similar skill and pod price can race together

Outcomes of the race are:
- Prize money is distributed
- Bets are paid off
- A [word commentary](https://github.com/premun/qsb/blob/master/images/zavody_4.png) is created, describing what was happening during the race
- A log of events (player clashes, crashes) is shown
- A speed and a distance graph is shown

![Speed graph](https://github.com/premun/qsb/blob/master/images/tutorial_graf.png) 

### Racing
When entering a race, you set the style how you want to race:

- You can be aggresive, which means more acceleration and speed but for the cost of a more probable crash (depends on track complexity)
- You can be more careful and crash less but for the cost of a slower race style
- Aggresivity/carefulness is also influenced by your race (breed)
- Heavy more endurant pods cause and take less damage, but are slower. Fast, light pods don't endure much

You can set how do you want to interact with other players:
- Offensive behaviour means you actively attack your opponents when close to them
- Defensive/offensive behaviour
- For each behaviour, there are 3 styles. Attacking has big bash, medium or small but more hits. Defensive behaviour has counter moves
- You can specifically target one player and focus on hitting him, or keep an eye on him and expect him attacking the most

- When one player attack the other, all this is taken into consideration:
  - Reflexes and aggresivity
  - Aggresivity/carefulness
  - Style of attack (both players offensive, or victim defensive)
  - Pod parameters (better turning gives you more chance to hit/avoid hit)
  - Player is focused
  - Current speed of players
- Based on all these parameters the fight can end up in a huge crash or just minor provoking.
- Sometimes you go for destroying the other pod, sometimes you want to slow down the other player and take him.
- Outcome of the fight can be:
  - Attacker misses
  - Attacker misses and crashes into the track (again depends on the style, pod...)
  - Attacker hits and players clash
- Depending on pod params, players receive unequal damage

- Racing is very complicated and actually requires some skill
- It is good to check up on your opponents, their pods and adapt your style to it, not just to the track you are racing on
- You can spy on your opponents for money and see their setup. More money you pay, more accurate intel you get. Again, it's better to have a good trading skill for lower prices.
- There are also NPC racers who obey the same set of rules as players, but for some reason the algorithm deciding their racing style came up pretty good, so they are very good opponents :)

### Fuels
- Each engine eats fuel, each with different efficiency
- Depending on the length of the track, different amount of fuel is needed
- There are 20+ different kinds of fuel
- The price of fuel goes up/down randomly
- Players can make money by trading fuel too

### Teams
- Players can form up teams, name it, create flags...
- Owner of the team can build team buildings:
  - To accomodate members
  - To stock team fuels
  - To earn money periodically
- Each next building costs more and more money
- Each member of a team has a function:
  - Owner - can build buildings, take up new members...
  - Merchant - can operate with team fuel stocks (trade in bigger volume than just)
  - Racer - can attend races and represent the team in the QSB Cup
- Members have contracts and get paid periodically too but they forfeit parts of their winnings to the team
- Merchant usually buys and repairs items of racers, makes bets with more money and trades with team fuel

### QSB Cup
- Each game period, there is one QSB Cup
- It starts after 1 month and goes for 1 month, it is a series of races, where only racers of teams can attend
- Only 2 players from each team can attend, usually one focuses on positioning, the other on crashing and slowing other players, but strategies vary
- Players receive points just like in Formula 1
- Winning team is placed in the hall of fame :)

### Bets
- You can bet on outcomes of races (positions, crashes...) and also make money as a bookmaker

### Tracks 
- Tracks are made out of tiles
- Each tile has parameters (max speed, hazardness)
- You can build the track in a flash visualizer and view the track before racing
- Some tracks really became legendary for their extreme complexity, some for being a drag race

![Example track](https://github.com/premun/qsb/blob/master/images/tutorial_trate.png)

### Other
There are other perks and stuff to do, I definitely forgot something:
- Players can use game forum, team forum or private messaging
- Players can collect achievements (such as "crash 3 players in one race", win "100 races" and so on)
- Players have wast statistics covering all aspects
- Players receive statistics about their income every day and can view their financial history
- There is a full blog **QSB World**, where players write stories from the QSB world, interviews, tutorials and other experiences (source code will be published shortly)
- Some players were given special status and could follow multiacc cheaters, teach others in a budy system and help with game maintaining
- There is an IRC bot, which enabled signing in and receiving info from game, sending messages or getting news
- There is a desktop app for messaging players
