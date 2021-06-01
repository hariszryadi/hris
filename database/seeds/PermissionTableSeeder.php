<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use App\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_ids = [];
        $permissions = [
            ['code' => 'M001', 'name' => '[Master] - Divisi', 'readable' => true, 'createable' => true, 'updateable' => true, 'deleteable' => true],
            ['code' => 'M002', 'name' => '[Master] - Pegawai', 'readable' => true, 'createable' => true, 'updateable' => true, 'deleteable' => true],
            ['code' => 'M003', 'name' => '[Master] - Kategori Cuti/Izin', 'readable' => true, 'createable' => true, 'updateable' => true, 'deleteable' => true],
            ['code' => 'M004', 'name' => '[Transaction] - Transaksi Cuti/Izin', 'readable' => true, 'createable' => false, 'updateable' => false, 'deleteable' => false],
            ['code' => 'M005', 'name' => '[Transaction] - Transaksi Lembur', 'readable' => true, 'createable' => false, 'updateable' => false, 'deleteable' => false],
            ['code' => 'M006', 'name' => '[User Config] - Account Pegawai', 'readable' => true, 'createable' => false, 'updateable' => true, 'deleteable' => false],
            ['code' => 'M007', 'name' => '[User Config] - Role', 'readable' => true, 'createable' => true, 'updateable' => true, 'deleteable' => true],
            ['code' => 'M008', 'name' => '[User Config] - User Admin', 'readable' => true, 'createable' => true, 'updateable' => true, 'deleteable' => true],
        ];

        // update or insert permissions
        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert($permission);
        }
        // get data permissions
        $data = DB::table('permissions')->get();
        // insert id permission to $permission_ids
        foreach ($data as $d) {
            $permission_ids[] = $d->id;
        }
        
        // find admin role
        $admin_role = Role::where('name', 'super-admin')->first();
        // synchronize permissions to admin role
        $admin_role->permissions()->sync($permission_ids);
    }
}
