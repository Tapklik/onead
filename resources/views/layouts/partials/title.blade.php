	<v-layout row wrap mt-0>
	    <v-flex xs2 class="valign-middle">
	    	<v-icon 
		    	style="cursor: pointer;" 
		    	large 
		    	class="grey--text"
		    	@click.stop="$root.drawer = !$root.drawer"
		    >menu</v-icon>
	    </v-flex>
	    <v-spacer></v-spacer>
	    <controls :user="user"></controls>
	 </v-layout>
	 <v-layout row wrap>
	 	<v-flex xs12>
	 		<v-card class="transparent" flat>
	 			<v-card-text>
	 				<span class="display-1 orange--text text--darken-4 valign-middle">{{ $slot }}</span>
	 			</v-card-text>
	 		</v-card>
	 	</v-flex>
	 </v-layout>
