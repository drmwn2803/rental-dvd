<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelFilm extends CI_Model
{
    //manajemen film
    public function getFilm()
    {
        return $this->db->get('film');
    }

    public function filmWhere($where)
    {
        return $this->db->get_where('film', $where);
    }

    public function simpanFilm($data = null)
    {
        $this->db->insert('film',$data);
    }

    public function updateFilm($data = null, $where = null)
    {
        $this->db->update('film', $data, $where);
    }

    public function hapusFilm($where = null)
    {
        $this->db->delete('film', $where);
    }

    public function total($field, $where)
    {
        $this->db->select_sum($field);
        if(!empty($where) && count($where) > 0){
            $this->db->where($where);
        }
        $this->db->from('film');
        return $this->db->get()->row($field);
    }
    
    //manajemen kategori
    public function getKategori()
    {
        return $this->db->get('kategori');
    }

    public function kategoriWhere($where)
    {
        return $this->db->get_where('kategori', $where);
    }

    public function simpanKategori($data = null)
    {
        $this->db->insert('kategori', $data);
    }

    public function hapusKategori($where = null)
    {
        $this->db->delete('kategori', $where);
    }

    public function updateKategori($where = null, $data = null)
    {
        $this->db->update('kategori', $data, $where);
    }

    //join
    public function joinKategoriFilm($where)
    {
        $this->db->from('film');
        $this->db->join('kategori','kategori.id =film.id_kategori');
        $this->db->where($where);
        return $this->db->get();
    }

	public function getLimitFilm()
	{
		$this->db->limit(5);
		return $this->db->get('film');
	}
}
