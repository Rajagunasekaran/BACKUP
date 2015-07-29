<?php
class testmodel extends CI_Model {
    public function insert_entry($data)
    {
        $this->db->insert('users', $data);
        return true;
    }
    public function initial_data()
    {
        $this->db->select('rc_id,rc_name');
        $this->db->from('role_creation');
        $this->db->order_by('rc_name');
        $query = $this->db->get();
        $result = $query->result();

        $query1=$this->db->query("SELECT DISTINCT LUM.ID,LUM.EMPLOYEE_NAME,LUM.USERNAME,LUM.PASSWORD,LUM.EMAIL,RC.RC_NAME,DATE_FORMAT(LUM.TIMESTAMP,'%d-%m-%Y %T') AS TIMESTAMP
        FROM USERS LUM INNER JOIN ROLE_CREATION RC WHERE LUM.RC_ID=RC.RC_ID GROUP BY LUM.EMPLOYEE_NAME ORDER BY LUM.USERNAME ASC");
        foreach ($query1->result() as $row)
        {
            $rowid=$row->ID;
            $empname=$row->EMPLOYEE_NAME;
            $username=$row->USERNAME;
            $password=$row->PASSWORD;
            $email=$row->EMAIL;
            $rcname=$row->RC_NAME;
            $timestamp=$row->TIMESTAMP;
            $result1[]=array($rowid,$empname,$username,$password,$email,$rcname,$timestamp);
        }
        return $resultset[]=array($result,$result1);
    }
}