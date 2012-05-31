<?php
/**
* A model for content stored in database.
*
* @package LydiaCore
*/
class CMContent extends CObject implements IHasSQL, ArrayAccess, IModule{
	/**
	* Members
	*/
	public $data;
	
	/**
	* Constructor
	*/
	public function __construct($id=null){
		parent::__construct();
		if($id){
			$this->LoadById($id);
		}
		else{
			$this->data = array();
		}
	}
	
	/**
	* Implementing ArrayAccess for $this->data
	*/
	public function offsetSet($offset, $value){if(is_null($offset)){$this->data[] = $value;} else{$this->data[$offset] = $value;}}
	public function offsetExists($offset){return isset($this->data[$offset]);}
	public function offsetUnset($offset){unset($this->data[$offset]);}
	public function offsetGet($offset){return isset($this->data[$offset]) ? $this->data[$offset] : null;}
	
	/**
	* Implementing interface IHasSQL. Encapsulate all SQL used by this class.
	*
	* @param $key string the string that is the key of the wanted SQL-entry in the array.
	* @args $args array with arguments to make the SQL query more flexible.
	* @return string.
	*/
	public static function SQL($key=null, $args=null){
		$order_order = isset($args['order-order']) ? $args['order-order'] : 'ASC';
		$order_by = isset($args['order-by']) ? $args['order-by'] : 'id';
		$limit = isset($args['limit']) ? 'LIMIT '.$args['limit'] : '';
		$queries = array(
			'drop table content'	=> "DROP TABLE IF EXISTS Content;",
			'drop table comments'	=> "DROP TABLE IF EXISTS ContentComments;",
			'create table content'	=> "CREATE TABLE IF NOT EXISTS Content (id INTEGER PRIMARY KEY, key TEXT KEY, type TEXT, title TEXT, data TEXT, filter TEXT, idUser INT, created DATETIME default (datetime('now')), updated DATETIME default NULL, deleted DATETIME default NULL, FOREIGN KEY(idUser) REFERENCES User(id));",
			'create table comments'	=> "CREATE TABLE IF NOT EXISTS ContentComments (id INTEGER PRIMARY KEY, data TEXT, idContent INT, created DATETIME default (datetime('now')), updated DATETIME default NULL, deleted DATETIME default NULL, FOREIGN KEY(idContent) REFERENCES Content(id));",
			'insert content'		=> 'INSERT INTO Content (key,type,title,data,filter,idUser) VALUES (?,?,?,?,?,?);',
			'insert comment'		=> 'INSERT INTO ContentComments (data,idContent) VALUES (?,?);',
			'select * by id'		=> "SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.id=? AND deleted IS NULL;",
			'select * by key'		=> "SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.key=? AND deleted IS NULL ORDER BY {$order_by} {$order_order} {$limit};",
			'select * by type'		=> "SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE type=? AND deleted IS NULL ORDER BY {$order_by} {$order_order} {$limit};",
			'select *'				=> "SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE deleted IS NULL ORDER BY {$order_by} {$order_order} {$limit};",
			'select comments'		=> 'SELECT * FROM ContentComments WHERE idContent=? ORDER BY created DESC;',
			'update content'		=> "UPDATE Content SET key=?, type=?, title=?, data=?, filter=?, updated=datetime('now') WHERE id=?;",
			'update content as deleted' => "UPDATE Content SET deleted=datetime('now') WHERE id=?;",
		);
		if(!isset($queries[$key])){
			throw new Exception("No such SQL query, key '$key' was not found.");
		}
		return $queries[$key];
	}
	
	/**
	* Implementing interface IModule. Manage install/update/deinstall and equal actions.
	*/
	public function Manage($action=null){
		switch($action){
			case 'install':
				try {
					$this->db->ExecuteQuery(self::SQL('drop table content'));
					$this->db->ExecuteQuery(self::SQL('drop table comments'));
					$this->db->ExecuteQuery(self::SQL('create table content'));
					$this->db->ExecuteQuery(self::SQL('create table comments'));
					
					
					
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Man Divorces Wife Over 550 Cats', "Cheating? Money issues? Fallen out of love? All could be reasons to get a divorce.\n\nBut for one man in southern Israel, the final straw that led him to seek a divorce this week was his wife’s decision to bring home 550 cats, The Times of Israel reports.\n\nThe cats apparently got in his way. They blocked his access to the bathroom, kept him from preparing meals in the kitchen and jumped onto the table as he ate and stole his food, the husband told the rabbinical court in Beersheba.\n\n“He was also unable to sleep in his bedroom because the surface of the marital bed was constantly covered with cats who refused to lie on the floor,” the paper reports.\n\nThe couple tried to reconcile at the behest of the court, but the wife wouldn’t part with her cats and instead split with her husband.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', '‘Divorce Hotel’ Ends Marriages in Luxury', "Oops. That quickie marriage in Vegas was a mistake. Not to worry, though. Dutch entrepreneur Jim Halfens has come up with an idea for an equally speedy solution.\n\nHis creation is called Divorce Hotel, a place where the unhappily-wed can check in for a weekend as a couple and check out single.\n\nFor a flat fee ranging from $3,500 to $10,000 (U.S.), the hotel provides mediators and lawyers to help couples with all the negotiations and paperwork necessary for divorce. All that’s required is to present the papers to a judge to make it official. (It also provides separate rooms for couples.)\n\nAccording to The New York Times, the Divorce Hotel concept is already operating in the Netherlands, where 16 out of the 17 couples who’ve tried it have successfully departed with divorce papers ready. Now, Mr. Halfens, 33, wants to expand the idea to the U.S.\n\nIn spite of its catchy name, Divorce Hotel isn’t an actual hotel; it’s more of a service package. Mr. Halfens has agreements with six high-end hotels in the Netherlands where couples can go to dissolve their marriages, the Times says.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Police Officer ‘Broke In House To Do Laundry’', "A US police officer is accused of breaking into his neighbour’s home to use the washing machine and tumble dryer.\n\nJason Rocco has been charged with trespassing and criminal mischief after allegedly breaking into a home in Avalon, Pennsylvania, reports WPXI Pittsburgh.\n\nAccording to police, the owner of the home contacted police after noticing his electric bill was high, despite not having lived in the house for months.\n\nThe homeowner told police he walked into his house and heard the dryer running. He found a load of clothes inside, including police and Marine Corps T-shirts.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Angry Customer Rams Truck into Taco Bell Restaurant Over Missing Taco', "It can be frustrating when your drive-thru food order gets messed up, but it is how an Ohio man handled the mistake that has him facing charges.\n\nPolice in Huber Heights, Ohio, near Dayton, arrested a man after he rammed his truck into a Taco Bell restaurant.\n\nEmployees told police the man became irate when he noticed a taco was missing from his order. Moments later, he drove his truck into the front doors of the restaurant, smashing the glass and bending the door frame.\n\nOfficers later arrested the man at his home on felony vandalism charges.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Man Earns Degree at 88 Years Old', "An 88-year-old Florida man graduating with a degree in medical coding and billing said he plans to put his education to use and find a job.\n\nHoward Hurwitz, who is scheduled to graduate next week from the Atlantic Technical Center in Coconut Creek, said he decided to pursue the degree after he tired of his online business selling janitorial supplies, the South Florida Sun Sentinel reported Tuesday.\n\n“I decided I would reinvent my life and take a new profession,” Hurwitz said. “I wanted to contribute to my own support, I didn’t want to rely on my children.”\n\n“While I was seeking employment I learned there were good opportunities in the medical field,” he said. “I decided I would make an attempt at learning medical office work, billing and coding.”", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Man Pulls Gun to Cut McDonald’s Drive-Through Line', "A Florida man was arrested this week after three women told police he pulled a gun on them so he could cut into a McDonald’s drive-through line, The Palm Beach Post reports.\n\nThe women said their car was side by side James Lee Cruz’s vehicle at the fast-food restaurant in West Palm Beach, Fla., when he took out a gun and pointed it at them.\n\nIn fear, the women backed up and allowed Cruz to pass them, the paper reports.\n\nThe women then took down Cruz’s license plate and called police as they followed him home.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Honor Student Thrown in Jail for Missing School to Support Family', "An eleventh grader in Texas was thrown in jail – just for missing school. However, honour student Diane Tran, 17, is no lazy truant. In fact, she’s quite the opposite.\n\nSince her parents divorced and left her and her two siblings, she has been the sole breadwinner and works two jobs to keep the family afloat.\n\nMs Tran said she works a full time job, a part-time job, and takes advancement and dual credit college level courses at Willis High School.\n\n‘[I take] dual credit U.S. history, dual credit English literacy, college algebra, Spanish language AP,’ she says of her impressive academic workload.\n\nHowever, the high-achiever cannot devote as much time as she would like to her schooling as she often misses an entire day.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Father Arrested for Tying up 4-Year-Old Daughter so He Could Play Violent Video Games', "A man has been charged with tying up his four-year-old daughter so he could play video games.\n\nHeath Howe, 27, of Sarasota, Florida decided last week to take his young child into the kitchen to tie her up with a rope so he could use the television to play ‘bad guy’ video games.\n\nWhen her mother realized what was happening, she did nothing to help the girl, according to authorities.\n\nThe rope was so tight on the girl that she was left with marks on her left and right arms.\n\nShe also suffered bleeding under her skin leaving red spots on her, authorities said.\n\nThe girl, who said her father was playing ‘bad guy games’, has not been identified.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Boom Boxes Cause Explosion Scare', "A road connecting to busy interstate highways 279 and 376 in Pittsburgh was closed before dawn Friday due to a report of a suspicious package.\n\nUpon further review, the “package” on a pedestrian bridge turned out to be four boom boxes taped together – and possibly left there by people who reportedly partied in the area hours before.\n\nWPXI-TV says a robot from the city bomb squad was brought in to examine the electronic bundle before police determined it was harmless and took it away.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Roving cows crash party, drink beer', "Police say a roving group of cows crashed a small gathering in a Massachusetts town and bullied the guests for their beer.\n\nBoxford police Lt. James Riter says he was responding to a call for loose cows on Sunday and spotted them in a front yard.\n\nRiter says the herd high-tailed it for the backyard and then he heard screaming. He says when he ran back there he saw the cows had chased off some young adults and were drinking their beers.\n\nRiter says the cows had knocked the beer cans over on a table and were lapping up what spilled. He says they even started rooting around the recycled cans for some extra drops.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Men Drove Stolen Church Van to Jail', "Two men were arrested in Stockton Tuesday for carjacking a 50-year-old man operating a church-run shuttle, say Stockton police.\n\nAccording to Stockton police reports, the driver was preparing to start the morning runs for residents of a center on the 500 block of W. Worth Street when Cortez Craig, 55, and Cornell Moses, 31, punched the man and stole the keys to the vehicle.\n\nPolice reports indicate the men punched the driver because they did not want to wait their turn for a ride to visit a friend in the county jail.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Man Faces Fine For Honking at Police Officer', "Swedish authorities said a 68-year-old man faces a fine for continuously honking his horn at a police officer dealing with a robbery.\n\nPolice said the man was driving down a central street in Eslov when he spotted a double-parked car with the motorist inside talking on the phone, The Local.se reported Thursday.\n\nThe man had enough room to get past, but instead honked his horn repeatedly in an attempt to get the vehicle to move, police said. The man did not stop when the car’s occupant held a badge out of his window to prove his police identity and was also not satisfied when the officer, who was in plain clothes, exited his vehicle and showed the 68-year-old his badge up close.\n\nPolice said the man was not satisfied until uniformed officers arrived at the scene and vouched for the officer’s identity. Police said the honking went on for more than a minute.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Police Chief Uses 10 Officers to Find Son’s iPhone', "Berkeley’s police chief is defending using 10 officers –some on overtime — to search for his teenage son’s stolen iPhone.\n\nChief Michael Meehan told the Oakland Tribune Wednesday there was no preferential treatment when the officers, including three detectives and a sergeant, went searching for his son’s phone apparently stolen from a school locker in January.\n\nMeehan says field supervisors decide how many officers to put on a case and he’s confident that the search for the phone that had a tracking device and took officers into neighboring Oakland was properly handled.\n\nMeehan was scrutinized in March for ordering a sergeant to a reporter’s home to ask for changes to an online story about a community meeting criticizing the alleged slow police response to an elderly man’s beating death.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Harry Truman’s Newspaper Bill Paid', "Harry Truman paid off his last debt Wednesday.\n\nThe former president — actually, longtime Truman impersonator Niel Johnson — handed $56.63 to Truman’s former paperboy, who said he never was paid for about six months worth of newspapers delivered to Truman’s Independence home in 1947.\n\n“Honesty was one of my policies,” Johnson told George Lund.\n\nThe account was settled, with interest, before a large crowd at the Tallgrass Creek retirement community in Overland Park, where Lund, 80, now lives.\n\nBefore the ceremony, Lund said he wasn’t sure he wanted the debt to be paid. It had always made for such a great story.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Man Saves Son, Ticketed For Rolling Car', "Frank Roder of Union County did the right thing. Once he saw his 5-year-old son, Aidan, running toward a cliff in Rahway River Park, he threw his Jeep into park and ran after the youngster.\n\nBut of course, as we all know, the Jeep was not in park and it tumbled into the river. Police fished the vehicle out of the water and slapped the stunned father with tickets for failing to set the brake properly and failing to produce his insurance card — which was in the vehicle, under water.\n\nThat’s crazy and deeply unfair. Roder made a stupid mistake, thinking he had set the brake but broke off his windshield-wiper control instead. He’ll have to pay for his confusion.\n\nBut penalizing him for not having his insurance card, when it was immersed in the river, reeks of a bureaucratic Catch-22 that would send any taxpayer off the deep end.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Man Faces Felony Charges After Hitting 10-Year-Old Boy', "A man smacked a disruptive 10-year-old boy who refused to stop talking and throwing popcorn in a movie theater and was arrested on felony assault charges.\n\nYong Hyun Kim, 21, says he thought the boy at the theater outside Seattle, Washington, was an adult . He told police he only lashed out after he asked the child and his friends to quiet down during a movie.\n\nOfficers say Kim hit the 10-year-old so hard on April 11, he knocked out a tooth and bloodied his mouth.\n\nThe boy described a man with long hair and 3-D glasses stepping over a row of theater seats to confront him and his friends, the Seattle Post-Intelligencer reports.\n\n‘You know what, I paid a lot of money to see this movie,’ Kim reportedly told the boy.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', '84-Year-Old Woman Trapped on Balcony For Two Days', "An 84-year-old Swedish woman was trapped in a folding chair for two days after it broke as she enjoyed the sunshine on her balcony.\n\nThe unnamed woman went out on to her balcony in Karlskrona, southeast Sweden, on Saturday to take advantage of the good weather when the chair collapsed underneath her, the Kvallsposten newspaper reported.\n\nDespite her best efforts, she was unable to free herself and was left helpless for 48 hours.\n\nWorried friends noticed she did not attend a church meeting Sunday and a newspaper inside her apartment was not picked up.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', '6th Grader wearing Marine Shirt Asked To Turn It Inside-Out', "School administrators told a Mississippi sixth-grader whose grunt brother is deployed to Afghanistan to turn his shirt inside-out because they were offended by its depiction of an anatomically correct U.S. Marine Corps bulldog.\n\nJordan Griffith, 13, of Ellisville, Miss., received the shirt from his older brother, Lance Cpl. Timothy Swann Jr., a member of 2nd Battalion, 9th Marines out of Camp Lejeune, N.C. Swann gave it to his little brother while he was on leave before deploying.\n\n“Jordan just idolizes Timothy,” said their mother, Sandy Griffith. “Timothy gave him the shirt and told him, ‘Always remember you’re a leader, not a follower.’”\n\nThe front of the shirt shows the dog’s head and body with the words “If you are not the lead dog.” The back shows the dog’s rear with the words “The view never changes.”", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Man With Zebra and Parrot in Truck Receives DUI', "An Iowa man stopped outside a Dubuque bar with a small zebra and a parrot in his truck has been charged with drunken driving.\n\nKCRG-TV reports officers arrested 56-year-old Jerald Reiter of Cascade on Sunday in the parking lot of the Dog House bar, where people had been taking photos of the animals.\n\nReiter says the zebra and macaw parrot are pets and like riding in the truck. Reiter claims he sometimes takes the animals into the bar, but the owner says they’re not allowed inside.\n\nOfficers gave Reiter a field sobriety test and charged him with drunken driving. Reiter disputes the arrest. He says he was about to let a passenger, a person, begin driving.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', '6-Year-Old Brings Pot to School', "A six-year-old’s show-and-tell presentation has led to a father’s arrest on felony drug charges after 80 grams of marijuana and a scale were pulled from a backpack.\n\nLarry Cornelius Stephens, 25, of St Petersburg Florida, is accused of placing the drugs in his kindergartener’s bag before dropping the child off at Campbell Park Elementary School on Tuesday morning.\n\nOnce discovering the bag’s contents, the child, who was described as beaming by the teacher, presented it saying, ‘Look what I got!’ according to the Tampa Bay Times.\n\nThat teacher immediately called police.\n\nRealizing his mistake, Stephens returned to the school minutes later telling someone he needed the marijuana back to ‘take care of his business and take care of his family,’ according to police.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Crossing Guard Returns $1,800 Found Hanging out of ATM', "What a whopping shopping spree it could have been. A crossing guard in Florida is being hailed as hero after she returned $1,800 she found hanging out of an ATM machine.\n\nAdriana Allen told the South Florida Sun Sentinel that she saw the money hanging out of the Chase ATM in Boynton Beach when she drove up to it to get her own money out.\n\nShe said she didn’t even consider taking it for herself.\n\n“It’s just not right,” she told the newspaper. “That’s the way I was brought up. What you don’t earn, you don’t get.”\n\nSo instead of treating herself to some new shoes, she tried to feed the money back into the slot, according to the report.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', '5-Year-Old Calls 911, Saves Choking Brother', "A little girl sprang into action and displayed a heroic side at her Amityville, Long Island home when she saw that her baby brother was choking.\n\nWCBS 880′s Sophia Hall said that she found it hard to believe that she was talking with a five-year-old when she spoke with Grace Varley, mainly because of how articulate she was.\n\nVarley’s parents said that the little girl — who was wearing a pink dress when Hall met with her — is a hero, because when her two-year-old brother began choking on a chicken nugget, she knew exactly what to do.\n\n“When Nana ran out of the house I called 911,” Grace explained.\n\nAs their grandmother was babysitting Grace and her brother, Myles, he began to choke. The grandmother began to panic and ran outside to find help, and that is when Grace stayed cool and called 911. She said that she loves her brother very much — not to mention princesses and the color pink.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'NY Man Who Dressed as Dead Mother in Scam Gets 13 Years', "A man who dressed up as his mother in a bizarre real estate fraud that involved doctoring her death certificate and cashing her Social Security checks for six years after she died was sentenced Monday to more than 13 years behind bars.\n\nThomas Parkin was convicted May 3 on charges including grand larceny and mortgage fraud. He was sentenced Monday to 13 2/3 to 41 years in prison. Prosecutors said the scheme lasted six years and involved Parkin wearing a blond wig, dress and oversized sunglasses.\n\nThe 51-year-old Parkin said at sentencing that he never hurt anyone or used stolen funds for personal gain or injury.When his mother, Irene Prusik, died in 2003 at age 73, he began impersonating her to cash her Social Security checks and keep her $2.2 million brownstone in the Brooklyn neighborhood of Park Slope, prosecutors said. The house had been deeded to Thomas Parkin, but he couldn’t make mortgage payments and the house was later sold at a foreclosure auction, prosecutors said.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Man Stabbed in the Chest, Saved By Implanted Heart Defribillator', "A man’s implanted heart defibrillator may have saved his life in an unexpected way — by stopping a knife.\n\nSan Diego police say the 57-year-old got into an argument with an acquaintance early Thursday near some elevators at the trolley station for the Fashion Valley shopping mall.\n\nPolice say the acquaintance pulled a folding knife and stabbed the man in the chest. The knife hit the man’s defibrillator, a device that shocks the heart if it gets dangerously out of rhythm.\n\nPolice say the man was taken to a hospital with serious injuries. His name hasn’t been released.\n\nAuthorities arrested 60-year-old Richard Kiley at another trolley station on suspicion of attempted murder.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews', 'page', 'Cemetery Wedding: Couple Gets Married At Parents’ Gravestones', "It’s not uncommon for a groom or bride to honor a deceased parent on their wedding day, but one Minnesota couple took it a step further, exchanging vows in front of their parents’ gravestones at their wedding on Saturday.\n\nWhile it might seem like a strange venue to most guests, Diane Waller and Randy Kjarland told the Austin Daily Herald that they felt that it was the right way to include their parents in their Big Day, since their parents had always approved of their relationship.\n\n“How cool is that?” Waller told the newspaper. “To honor our parents and family, to have them with us in a weird sort of way.”\n\nAs expected, not everyone approved of the couple’s odd decision to wed at the Oakwood Cemetery in Austin, Minnesota. “Some people think it’s a joke, but it’s actually going to be very respectful of why we’re there,” Waller said before the wedding ceremony. “Other people, when they hear our story, have cried.” Approximately 50 to 60 guests attended the graveyard wedding.\n\nBut according to the couple, the cemetery seemed like the right place to wed since Kjarland originally proposed to Waller in front of her parents’ gravestones — after respectfully asking for permission to marry their daughter, of course.", 'plain', $this->user['id']));



					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport', 'page', 'Roy Halladay Injury Dooms Phillies to Fielding Team with Just $50.4 Million in Starting Pitching', "The Philadelphia Phillies are facing the harsh reality that their season may be lost in light of the news that starting pitcher Roy Halladay is likely out for six to eight weeks due to shoulder pain.\n\nHalladay, the second-highest paid Phillies starter behind Cliff Lee, now forces Philadelphia to move forward with a rotation consisting of nothing more than Cliff Lee, Cole Hamels, Vance Worley, Joe Blanton and Kyle Kendrick.\n\n“When you invest $70 million in a rotation, but end up only being able to pitch a $50 million rotation for a month or so, that really hurts,” said Phillies general manager Ruben Amaro. “And Cliff Lee and Hamels make up $36.5 million of that. So we now only have one Cy Young winner in our rotation and, for the first time in years, less than half of our rotation has made an All-Star Game. Less than half! It’s pretty bleak.”", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport', 'page', 'Report: Heat Decide to Put Chris Bosh Down Due to His Mounting Veterinarian Bills', "The Miami Heat have reportedly made a tough decision regarding Chris Bosh and are enjoying their last hours with him before they will take him back to the vet tomorrow to be euthanized.\n\n“It’s the hardest thing I’ve ever had to decide, but it’s for the best,” said Lebron James, his eyes still full of tears after meeting with teammates. “He’s the best Bosh I’ve ever had. But I don’t want him to suffer. And even if he gets better, we can’t know if he’ll ever be the same. This is the most merciful thing to do.”\n\nHeat forward Dwyane Wade said he is having trouble looking at Bosh’s face since the decision was made by a unanimous team vote.\n\n“He has no idea what’s going to happen,” said Wade, his lip quivering. “Even though his body is failing, he still has that same happy, stupid look on his face. And those deep Bosh eyes … I just … I can’t look at him. It hurts too much.”\n\nYet while the Heat players say it was an emotional decision, there was a cold, practical element to it, as well.\n\n“I wish it wasn’t this way, but it is,” said team president Pat Riley. “We’ve been dropping tons of money at the vet paying for his care and there’s no end in sight. Just yesterday I spent $113 for some ointment for his ears. That’s crazy. I love him, but at the end of the day, he’s still only a Bosh. He’s not a human being.”", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport', 'page', 'Irate Pacers Fans Destroy Corn, a Duck in Postgame Riots', "Following the Pacers’ 105-93 loss to the Miami Heat on Thursday to end their 2012 season, the team’s fans took to the streets in anger. Reminiscent of riots from Canucks and Lakers fans in recent years, the Pacers faithful vented their frustrations in a destructive manner all across Indiana’s desolate landscape.\n\nResidents in Blackford and Delaware counties recount an unruly night of corn trampling and livestock taunting that destroyed literally hundreds of dollars worth of crops and left at least one duck dead.\n\n“Yup, someone done gone decapitated a duck with a subsoiler,” said Clint Neel, sheriff and assistant faith healer of Fairmount. “The duck was pretty drunk, though, so I figger he was just as much to blame.”\n\nPolice were mostly helpless to contain the disorder, with about half of their interceptor tractors on loan to departments downstate. While several of the alleged rioters were taken into custody, they were promptly released when officers couldn’t find the Master Lock to keep them in the bandit closet.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport', 'page', 'Lebron James Fails to Win Ring in 2nd Round Playoff Victory', "Miami Heat forward Lebron James failed to win an NBA championship ring again Thursday night when the Heat advanced past the Indiana Pacers in the 2nd Round of the playoffs, leaving James two series victories short of a title.\n\nJames bristled at media questions following the game about his inability to win it all, saying “the playoffs aren’t over” – yet the fact remains that defeating the Pacers left the supposed best player in basketball still without an NBA championship.\n\nThe MVP has advanced out of the 2nd Round in past postseasons only to lose later on, suggesting 2012 is shaping up exactly like his well-known playoff failures.\n\n“I’m not sure you all are understanding how the playoffs work,” said James, pathetically defending himself. “Advancing out of the 2nd Round is necessary in order to get to the NBA Finals and win. Yes, I’m still short of the ultimate goal, but I can’t and won’t apologize for winning this series. It was a requirement to get a ring.”\n\nIn the decisive Game 6, James fell short of his series’ highs in points, rebounds and assists, suggesting he is regressing as the Eastern Conference and NBA Finals near.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport', 'page', '49ers Excited That So Far Randy Moss Isn\'t Behaving Like a Total Dickhead', "Randy Moss participated in OTA’s with the San Francisco 49ers yesterday and his coaches and teammates couldn’t be happier.\n\n“Randy showed up on time and did what he was asked to do,” said head coach Jim Harbaugh. “It was a real delight to see. He’s really started to mature.”\n\nThe 35 year-old receiver was out of football last season after jumping around between three teams during the 2010 season. The 49ers signed him to a one-year contract this winter to give Moss what is likely his best, last shot in the NFL.\n\n“I wouldn’t say he was overly friendly,” said quarterback Alex Smith. “Or even nice. However, he didn’t come up to me and tell me that I suck ass, which is what I expected him to. He didn’t spit on me, or kick me in the nuts or take a piss in my locker or anything like that. It was really encouraging.”", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport', 'page', 'Drunk, Depressed Jack Nicholson Spotted Buying LA Kings Tickets', "Academy Award-winning actor and Los Angeles Lakers superfan Jack Nicholson has been reduced to purchasing tickets to see the Los Angeles Kings after his beloved Lakers were bounced out of the playoffs early for the second season in a row.\n\n“I want my regular seat on the floor for … whatever it is the hockey team is doing. Stanley’s cups,” Nicholson told a ticket window operator at the Staples Center this morning.\n\n“I’m sorry, sir. But your seat would be on the ice at a hockey game. They’re not available,” Nicholson was told.\n\n“What? There’s ice? Goddamit. Let me speak to Jerry Buss immediately! I want my seats!” screamed the actor.\n\nNicholson was then informed that Buss is not the owner of the Kings, which prompted him to run his hands through his hair and make angry and exasperated facial expressions for more than 10 minutes. He was then led away by Staples Center security.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport', 'page', 'Stan Van Gundy to Return to Role as Paul Bearer on WWE', "Less than a day after being fired by the Orlando Magic, now-former head coach Stan Van Gundy announced that he will return to his role as Paul Bearer, manager of The Undertaker, on WWE broadcasts.\n\nVan Gundy, who has been sporadically playing the Paul Bearer character since the early 1990s, has been limited in his WWE appearances by his obligations as a basketball coach. With Undertaker filling a less active role in the WWE in recent years, Van Gundy will also appear in storylines featuring Kane, Undertaker’s half brother.\n\n“It just seemed like the timing was right to play Bearer again,” Van Gundy said in a press conference. “My hope is that the WWE superstars will treat me with the respect I was denied by those on my own team this season.”\n\nVan Gundy’s spherical figure, ghostly tenor and macabre mustache are perfectly suited to play Paul Bearer, who masquerades as a deranged, pallid funeral director. Reminiscent of his real-life relationship with superstar Dwight Howard, Bearer is frequently bullied and overpowered by those he represents, and has been buried alive on multiple occasions.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport', 'page', 'Blood-Spattered Kobe Bryant Insists Pau Gasol Flew Back to Spain as Soon as the Season Ended', "Lakers star Kobe Bryant claims teammate Pau Gasol was not brutally murdered and, in fact, immediately flew home to Spain following Los Angeles’ season-ending loss to the Oklahoma City Thunder.\n\n“Yeah, I’ve heard the crazy rumors, too,” said Bryant, wiping blood off of his face with a towel while speaking to Oklahoma City police. “I guess because a few people claim they heard screams and saw me attacking Pau with an ax? I don’t know. People say crazy things. But, no, right after the game ended, Pau headed to the airport and flew home. He said he was going there forever and would never be back.”\n\nBryant then picked up his blood-soaked axe and held it menacingly in the direction of his teammates: “Didn’t Pau say that, guys,” Bryant said to them. “Tell the good officers.”\n\nBryant’s Lakers teammate, crying and in shock, nodded their heads in agreement.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport', 'page', 'Slumping Michael Phelps Nearly Drowns During 200-Meter Butterfly', "Following two second place finishes last weekend at the Charlotte Grand Prix event, 14-time Olympic gold medal winner Michael Phelps struggled even more today at the Miami Swim Nationals, nearly drowning to death after diving into the pool for 200-meter butterfly qualifying.\n\nWhen the gun sounded to start his heat, Phelps dove into the pool and then didn’t resurface for several seconds. He then appeared at the top of the water, wildly flailing and gasping for air, before dropping below the top of the water again. Lifeguards and paramedics then dove into the pool and pulled Phelps out, where mouth-to-mouth resuscitation was conducted.\n\n“All athletes go through slumps,” said Gary Mourning, Phelps’ coach. “Just look at Albert Pujols. The London Olympics are still two months away, so I am fully confident that Michael will be back in form by then.”\n\nPhelps spoke to reporters briefly from his hospital bed at University of Miami hospital.\n\n“I just need to focus on the fundamentals,” he said. “You know, not swallowing water, moving my arms and legs in a controlled manner so I don’t fall to the bottom, that sort of thing. I’ll get through it.”", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport', 'page', 'Injury-Riddled NBA Announces Finals Will be 3-on-3', "The NBA announced this morning that following a drastic increase in injuries during the 2012 playoffs, the league would be adopting a new format for the NBA Finals.\n\n“It’s obvious we’re not going to have enough players left to play a full NBA Finals,” commissioner David Stern said, “so we’ll be replacing the Finals with a 3-on-3 game.”\n\nThe NBA playoffs have already seen players like Derrick Rose, Iman Shumpert, Baron Davis and Chris Bosh go down with injuries. On Monday, both Avery Bradley and Kendrick Perkins missed extended portions of their respective games, leading Stern to make the drastic, but necessary, change.\n\nUnder the new NBA Finals format, the winners of the Eastern and Western Conferences will still meet, but instead of being forced to field full rosters, each team will only need three healthy players. The best-of-7 series will be reduced to a single game, using standard halfcourt 3-on-3 rules.\n\n“We’ll play to 21, make-it-take-it, and you have to clear past the three point line, unless its an airball,” Stern said. “It’ll just be one game, unless the loser angrily declares ‘best of three’ within 24 seconds of completion of the first game. Standard three-on-three rules, basically.”", 'plain', $this->user['id']));



					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'Mexican mother arrested after son\'s eyes gouged out', "A mother in Mexico has been arrested on suspicion of gouging out the eyes of her 5-year-old son during a ceremony.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'Saudi ghost-hunters raid "haunted" hospital', "The dingy corridors and gloomy wards of a long-abandoned Saudi Arabian hospital have drawn hundreds of amateur ghost hunters who believe it to be haunted by jinn, the malevolent spirits of the Koran and Arabian mythology.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'South Africa painting debate exposes racial rifts', "South Africa's ruling ANC went to court on Thursday seeking to remove from public display a painting of President Jacob Zuma with his genitals exposed, saying the work is symbolic of the lingering racial oppression of apartheid.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'Mountain lion wanders into California city center, is killed', "A mountain lion ventured into the center of a crowded Southern California city on Tuesday, and was shot and killed when authorities had trouble corralling the animal in the courtyard of a building, police said.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'Phony "dying bride" ordered to repay victims', "A New York bride who faked having terminal cancer to swindle well-wishers into funding her dream wedding and honeymoon to the Caribbean on Wednesday was ordered to repay more than $13,000 to her victims, prosecutors said.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'Are sweaty brokers more ethical?', "If you want to know how ethical your broker is, give them a moral dilemma and see how much they sweat before deciding what to do.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'Fired for being "too hot," New Jersey woman claims', "A New Jersey woman said on Monday that she was dismissed from a temporary job at a New York lingerie warehouse because her male employers felt she was too busty and dressed too provocatively for the workplace.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'Japan train with "rice balls" to sharpen soccer skills', "Japan have come up with a novel way of preparing themselves for this year's London Olympic men's soccer tournament - training with odd-bouncing triangular 'rice balls.'", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'Cloak and dagger world of spies exposed in NYC show', "The mysterious cloak and dagger world of international espionage and its real-life heroes and villains are exposed in a new exhibition, the first to be sanctioned by U.S. intelligence agencies.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'Canada museum kills masturbation video after outcry', "Canada's federal science museum has removed an animated video showing youth masturbating from an upcoming sex exhibit following a public outcry, a museum spokesman said.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'Paris exotic dancers strike, say wages "miserable"', "Topless dancers at the renowned Crazy Horse night club in Paris have gone on strike, saying they are not being paid enough to take the shirts off their backs.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'Aussie shooter Mark squirms under "mankini" bet threat', "Australian Olympic shooting gold medalist Russell Mark is set to parade in a lime-green \"mankini\" made famous by the movie character \"Borat\" at the opening ceremony of the London Olympics as the penalty for losing a bet.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'Man bitten by rattlesnake at Washington state Walmart', "When Mica Craig reached down to brush what he thought was a stick off some mulch in the garden section of a Washington state Walmart, it turned around and sank its fangs into his hand.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'Topless Ukraine activist grabs Euro soccer cup', "A Ukrainian women's rights activist stripped to the waist and seized the Euro-2012 soccer trophy while it was on public display in Kiev on Saturday in a protest against the forthcoming month-long championship.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'Stripper fired from newspaper alleges discrimination', "A newspaper reporter who was fired after another publication reported that she worked part-time as a stripper says she has filed a complaint against her former employer with the Equal Employment Opportunity Commission, alleging sex discrimination.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'Afterlife comes at a discount for diehard Benfica fans', "Diehard fans of Portugal's Premier League soccer club Benfica can now rest in peace knowing they can be buried at a discount thanks to a deal signed between the club and the country's largest undertakers agency.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('knews-notice', 'post', 'Gambling, drinking monks raise hell in South Korea', "Six leaders from South Korea's biggest Buddhist order have quit after secret video footage showed some supposedly serene monks raising hell, playing high-stakes poker, drinking and smoking.", 'plain', $this->user['id']));



					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport-notice', 'post', 'Andy Carroll flops at the yes/no game', "England fans will be hoping Andy Carroll is better suited to international football than he is schoolyard games, after the Liverpool striker failed to complete 60 seconds of ‘the yes/no game’.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport-notice', 'post', 'Adem Ljajic booted from Serbia squad for not singing national anthem', "Serbia coach Sinisa Mihajlovic has dropped Adem Ljajic after the striker failed to sing the national anthem before Saturday’s 2-0 defeat to Spain.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport-notice', 'post', 'Eden Hazard made to buy bottle of bubbly for being late for Belgium bus', "Chelsea's potential new signing Eden Hazard was ordered to buy a bottle of champagne as punishment for being late for the team bus while on international duty for Belgium.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport-notice', 'post', 'Manchester United winger Luis Nani beatboxes at press conference', "Manchester United winger Luis Nani showed off his musical talents when he beatboxed at a press conference for the Portuguese national team.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport-notice', 'post', 'Retiring Vadim Evseev replaced by five-year-old in testimonial', "Near to the end of his last match, Russian defender Vadim Evseev was called off the pitch and replaced by a five-year-old boy.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport-notice', 'post', 'England to be provided with \'team pants\' for Euro 2012', "England stars have been told to leave their pants at home for their summer’s European Championships in Poland and Ukraine, as ‘team underwear’ will be provided for them.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport-notice', 'post', 'Newcastle boss Alan Pardew \'taking tips from F1 strugglers Marussia\'', "After a highly successful season in which Newcastle finished fifth in the Premier League, Magpies fans might not expect manager Alan Pardew to take tips from one of Formula 1's worst teams, Marussia - but he is.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport-notice', 'post', 'Rio Ferdinand mourns Euro 2012 snub with Thailand All-Stars match', "As Rio Ferdinand's former England team-mates prepare for Euro 2012, the dejected-looking Manchester United centre back suffered the additional humiliation of a defeat at the hands of a Thailand All-Star XI in Bangkok.", 'plain', $this->user['id']));
					$this->db->ExecuteQuery(self::SQL('insert content'), array('sport-notice', 'post', 'Mario Balotelli gets famous footballers\' haircuts in new Nike advert', "Manchester City’s Mario Balotelli may not need any help in being remembered at Euro 2012, but that still hasn’t stopped him experimenting with a Carlos Valderrama perm in a new advert.", 'plain', $this->user['id']));
					
					
					
					return array('success', 'Successfully created the database tables and created a default "Hello World" blog post, owned by you.');
				}
				catch(Exception$e){
					die("$e<br />Failed to open database: " . $this->config['database'][0]['dsn']);
				}
			break;
			default:
				throw new Exception('Unsupported action for this module.');
			break;
		}
	}
	
	/**
	* Save content. If it has a id, use it to update current entry or else insert new entry.
	*
	* @return boolean true if success else false.
	*/
	public function Save(){
		$msg = null;
		if($this['id']){
			$this->db->ExecuteQuery(self::SQL('update content'), array($this['key'], $this['type'], $this['title'], $this['data'], $this['filter'], $this['id']));
			$msg = 'update';
		}
		else{
			$this->db->ExecuteQuery(self::SQL('insert content'), array($this['key'], $this['type'], $this['title'], $this['data'], $this['filter'], $this->user['id']));
			$this['id'] = $this->db->LastInsertId();
			$msg = 'created';
		}
		$rowcount = $this->db->RowCount();
		if($rowcount){
			$this->AddMessage('success', "Successfully {$msg} content '" . htmlEnt($this['key']) . "'.");
		}
		else{
			$this->AddMessage('error', "Failed to {$msg} content '" . htmlEnt($this['key']) . "'.");
		}
		return $rowcount === 1;
	}
	
	/**
	* Delete content. Set its deletion-date to enable wastebasket functionality.
	*
	* @return boolean true if success else false.
	*/
	public function Delete(){
		if(!$this->user->IsAdministrator()){
			$this->AddMessage('error', "Failed to set content '" . htmlEnt($this['key']) . "' as deleted. You need to be administrator for that!");
			return 0;
			exit;
		}
		if($this['id']){
			$this->db->ExecuteQuery(self::SQL('update content as deleted'), array($this['id']));
		}
		$rowcount = $this->db->RowCount();
		if($rowcount){
			$this->AddMessage('success', "Successfully set content '" . htmlEnt($this['key']) . "' as deleted.");
		}
		else{
			$this->AddMessage('error', "Failed to set content '" . htmlEnt($this['key']) . "' as deleted.");
		}
		return $rowcount === 1;
	}
	
	/**
	* Save Comment.
	*/
	public function Comment($data, $id){
		$this->db->ExecuteQuery(self::SQL('insert comment'), array($data, $id));
		if($this->db->RowCount() == 0){
			$this->AddMessage('error', 'Failed to insert comment.');
			return false;
		}
		return true;
	}
	
	/**
	* Load content by id.
	*
	* @param id integer the id of the content.
	* @return boolean true if success else false.
	*/
	public function LoadById($id) {
		$res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by id'), array($id));
		if(empty($res)) {
			$this->AddMessage('error', "Failed to load content with id '$id'.");
			return false;
		}
		else{
			$this->data = $res[0];
		}
		return true;
	}
	
	
	/**
	* Load content by id with comments.
	*
	* @param id integer the id of the content
	* @return array with listing or null of empty.
	*/
	public function LoadByIdWithComments($id) {
		try{
			$result = null;
			$res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by id'), array($id));
			if(!empty($res)){
				$result = $res[0];
				$res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select comments'), array($id));
				if(!empty($res)){
					$result['comments'] = $res;
				}
			}
			return $result;
		}
		catch(Exception$e){
			echo $e;
			return null;
		}
	}
	
	/**
	* List all content.
	*
	* @param $args array with various settings for the request. Default is null.
	* @return array with listing or null if empty.
	*/
	public function ListAll($args=null){
		try{
			if(isset($args) && isset($args['type'])){
				return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by type', $args), array($args['type']));
			}
			else if(isset($args) && isset($args['key'])){
				return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by key', $args), array($args['key']));
			}
			else{
				return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select *', $args));
			}
		}
		catch(Exception$e){
			echo $e;
			return null;
		}
	}
	
	/**
	* Filter content according to a filter.
	*
	* @param $data string of text to filter and format according its filter settings.
	* @return string with the filtered data.
	*/
	public static function Filter($data, $filter){
		switch($filter){
			/*case 'php': $data = nl2br(makeClickable(eval('?>'.$data))); break;
			case 'html': $data = nl2br(makeClickable($data)); break;*/
			case 'htmlpurify': $data = nl2br(CHTMLPurifier::Purify($data)); break;
			case 'bbcode': $data = nl2br(bbcode2html(htmlEnt($data))); break;
			case 'plain':
			default: $data = nl2br(makeClickable(htmlEnt($data))); break;
		}
		return $data;
	}
	
	/**
	* Get the filtered content.
	*
	* @return string with the filtered data.
	*/
	public function GetFilteredData(){
		return $this->Filter($this['data'], $this['filter']);
	}
}