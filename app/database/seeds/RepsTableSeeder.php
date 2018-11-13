<?php


class RepsTableSeeder extends Seeder
{

	public function run()
	{
		DB::table('reps')->delete();
		Rep::create(array(
			'name'     => 'Admin',
			'username' => 'admin',
			'email'    => 'email@domain.com',
			'address1'    => 'address1',
			'address2'    => 'address2',
			'address3'    => 'address3',
			'company'    => 'Company',
			'company_email'    => 'email@comapny.com',
			'phone'    => '5555555555',
			'fax'    => '5555555555',
			'password' => Hash::make('password'),
		));
	}

}


?>