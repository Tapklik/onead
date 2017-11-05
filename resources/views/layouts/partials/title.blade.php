<v-container class="fluid">
	<v-layout row wrap>
	    <v-flex xs12 md4 class="valign-middle">
	        <span class="display-1 grey--text text--lighten2 valign-middle">{{ $slot }}</span>
	        
	        
	    </v-flex>
	    <v-spacer></v-spacer>
	    <controls :user="user"></controls>
	 </v-layout>
 </v-container>